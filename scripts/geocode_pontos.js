
// Estado global para controlar requisições
let buscandoCep = false;
let geocodificando = false;

// Busca CEP automaticamente ao sair do campo
document.getElementById('cep').addEventListener('blur', async function () {
    const cep = this.value.replace(/\D/g, '');

    // Só busca se tiver 8 dígitos e não estiver buscando
    if (cep.length === 8 && !buscandoCep) {
        await buscarCep();
    }
});

// Geocodifica automaticamente ao preencher o número
document.getElementById('numero').addEventListener('blur', async function () {
    const numero = this.value.trim();
    const endereco = document.getElementById('endereco').value.trim();
    const cep = document.getElementById('cep').value.replace(/\D/g, '');

    // Só geocodifica se tiver todos os dados e não estiver geocodificando
    if (numero && endereco && cep.length === 8 && !geocodificando) {
        await geocodificarEndereco();
    }
});

// Busca CEP e preenche endereço
async function buscarCep() {
    if (buscandoCep) return; // Evita múltiplas requisições

    const cep = document.getElementById('cep').value.replace(/\D/g, '');
    const statusDiv = document.getElementById('geoStatus');

    if (cep.length !== 8) {
        return;
    }

    buscandoCep = true;

    // Adiciona classe de loading no campo CEP
    const cepInput = document.getElementById('cep');
    cepInput.classList.add('loading');
    cepInput.disabled = true;

    // Mostra feedback visual
    statusDiv.textContent = '🔍 Buscando endereço...';
    statusDiv.className = 'geo-status bg-blue-100 text-blue-700';
    statusDiv.classList.remove('hidden');

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            statusDiv.textContent = '❌ CEP não encontrado. Verifique e tente novamente.';
            statusDiv.className = 'geo-status geo-error';
            cepInput.classList.remove('loading');
            cepInput.disabled = false;
            buscandoCep = false;
            return;
        }

        // Preenche campos
        document.getElementById('endereco').value = data.logradouro || '';

        // Armazena dados do CEP para usar na geocodificação
        window.dadosCep = {
            cidade: data.localidade,
            estado: data.uf,
            bairro: data.bairro
        };

        statusDiv.textContent = `✓ Endereço encontrado: ${data.logradouro}, ${data.bairro}, ${data.localidade}-${data.uf}`;
        statusDiv.className = 'geo-status geo-success';

        // Remove loading e reabilita campo
        cepInput.classList.remove('loading');
        cepInput.disabled = false;

        // Foca no próximo campo (número)
        document.getElementById('numero').focus();

        console.log('✅ CEP encontrado:', data);

    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        statusDiv.textContent = '❌ Erro ao buscar CEP. Verifique sua conexão.';
        statusDiv.className = 'geo-status geo-error';
        cepInput.classList.remove('loading');
        cepInput.disabled = false;
    } finally {
        buscandoCep = false;
    }
}

// Geocodifica automaticamente ao preencher número
async function geocodificarEndereco() {
    if (geocodificando) return; // Evita múltiplas requisições

    const endereco = document.getElementById('endereco').value;
    const numero = document.getElementById('numero').value;
    const cep = document.getElementById('cep').value.replace(/\D/g, '');

    if (!endereco || !numero || !cep) {
        return; // Aguarda todos os campos estarem preenchidos
    }

    geocodificando = true;

    // Adiciona classe de loading no campo número
    const numeroInput = document.getElementById('numero');
    numeroInput.classList.add('loading');
    numeroInput.disabled = true;

    // Usa dados do ViaCEP se disponíveis
    const cidade = window.dadosCep?.cidade || 'Brasil';
    const estado = window.dadosCep?.estado || '';
    const bairro = window.dadosCep?.bairro || '';

    // Monta endereço COMPLETO com cidade e estado
    const enderecoCompleto = `${endereco}, ${numero}, ${bairro}, ${cidade}, ${estado}, Brasil`;

    const statusDiv = document.getElementById('geoStatus');

    statusDiv.textContent = '🗺️ Buscando coordenadas no mapa...';
    statusDiv.className = 'geo-status bg-blue-100 text-blue-700';
    statusDiv.classList.remove('hidden');

    console.log('🗺️ Geocodificando:', enderecoCompleto);

    try {
        const url = `https://nominatim.openstreetmap.org/search?` +
            `q=${encodeURIComponent(enderecoCompleto)}` +
            `&format=json&limit=1&countrycodes=br`;

        const response = await fetch(url, {
            headers: {
                'User-Agent': 'EletronicoVerde/2.0'
            }
        });

        const data = await response.json();

        if (data && data.length > 0) {
            document.getElementById('latitude').value = data[0].lat;
            document.getElementById('longitude').value = data[0].lon;

            statusDiv.textContent = `✓ Coordenadas encontradas! Latitude: ${data[0].lat}, Longitude: ${data[0].lon}`;
            statusDiv.className = 'geo-status geo-success';

            console.log('✅ Geocodificação bem-sucedida:', data[0]);

            // Remove loading e reabilita campo
            numeroInput.classList.remove('loading');
            numeroInput.disabled = false;

            // Foca no próximo campo (hora início)
            setTimeout(() => {
                document.getElementById('hora_inicio').focus();
            }, 500);

        } else {
            console.log('⚠️ Nenhum resultado retornado');
            statusDiv.textContent = '⚠️ Coordenadas não encontradas. O ponto será cadastrado sem localização no mapa. Você pode ajustar o endereço e tentar novamente.';
            statusDiv.className = 'geo-status geo-error';
            numeroInput.classList.remove('loading');
            numeroInput.disabled = false;
        }

    } catch (error) {
        console.error('Erro ao geocodificar:', error);
        statusDiv.textContent = '⚠️ Erro ao buscar coordenadas. O ponto será cadastrado sem localização no mapa.';
        statusDiv.className = 'geo-status geo-error';
        numeroInput.classList.remove('loading');
        numeroInput.disabled = false;
    } finally {
        geocodificando = false;
    }
}

// Validação antes de enviar
function validarFormulario() {
    const lat = document.getElementById('latitude').value;
    const lng = document.getElementById('longitude').value;

    if (!lat || !lng) {
        return confirm('⚠️ As coordenadas não foram encontradas. O ponto não aparecerá no mapa.\n\nDeseja continuar mesmo assim?');
    }

    return true;
}

// Formata CEP automaticamente enquanto digita
document.getElementById('cep').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 5) {
        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
    }
    e.target.value = value;
});

// Formata telefone automaticamente
document.getElementById('telefone').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 10) {
        value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else {
        value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
    }
    e.target.value = value;
});

// Feedback visual nos campos enquanto estão sendo processados
document.getElementById('cep').addEventListener('focus', function () {
    this.style.borderColor = '#04A777';
});

document.getElementById('cep').addEventListener('blur', function () {
    this.style.borderColor = '#4a5565';
});

document.getElementById('numero').addEventListener('focus', function () {
    this.style.borderColor = '#04A777';
});

document.getElementById('numero').addEventListener('blur', function () {
    this.style.borderColor = '#4a5565';
});
