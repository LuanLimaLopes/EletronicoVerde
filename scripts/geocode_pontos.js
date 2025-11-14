// /eletronicoverde/scripts/geocode_pontos.js

// Estado global para controlar requisições
let buscandoCep = false;
let geocodificando = false;

// Aguarda o carregamento do DOM
document.addEventListener('DOMContentLoaded', function () {
    inicializarEventos();
});

/**
 * Inicializa todos os event listeners
 */
function inicializarEventos() {
    const cepInput = document.getElementById('cep');
    const numeroInput = document.getElementById('numero');
    const telefoneInput = document.getElementById('telefone');

    // Evento de busca de CEP ao sair do campo
    if (cepInput) {
        cepInput.addEventListener('blur', async function () {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length === 8 && !buscandoCep) {
                await buscarCep();
            }
        });

        // Formata CEP enquanto digita
        cepInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.replace(/^(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });

        // Feedback visual no foco
        cepInput.addEventListener('focus', function () {
            this.style.borderColor = '#04A777';
        });

        cepInput.addEventListener('blur', function () {
            if (!buscandoCep) {
                this.style.borderColor = '#4a5565';
            }
        });
    }

    // Evento de geocodificação ao preencher número
    if (numeroInput) {
        numeroInput.addEventListener('blur', async function () {
            const numero = this.value.trim();
            const endereco = document.getElementById('endereco')?.value.trim();
            const cep = document.getElementById('cep')?.value.replace(/\D/g, '');

            if (numero && endereco && cep && cep.length === 8 && !geocodificando) {
                await geocodificarEndereco();
            }
        });

        // Feedback visual no foco
        numeroInput.addEventListener('focus', function () {
            this.style.borderColor = '#04A777';
        });

        numeroInput.addEventListener('blur', function () {
            if (!geocodificando) {
                this.style.borderColor = '#4a5565';
            }
        });
    }

    // Formata telefone automaticamente
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else {
                value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }
            e.target.value = value;
        });
    }
}

/**
 * Busca CEP e preenche os campos de endereço automaticamente
 */
async function buscarCep() {
    if (buscandoCep) return; // Evita múltiplas requisições

    const cepInput = document.getElementById('cep');
    const statusDiv = document.getElementById('geoStatus');
    const cep = cepInput.value.replace(/\D/g, '');

    if (cep.length !== 8) {
        return;
    }

    buscandoCep = true;

    // Adiciona classe de loading no campo CEP
    cepInput.classList.add('loading');
    cepInput.disabled = true;

    // Mostra feedback visual
    mostrarStatus('🔍 Buscando endereço...', 'info');

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            mostrarStatus('❌ CEP não encontrado. Verifique e tente novamente.', 'erro');
            cepInput.classList.remove('loading');
            cepInput.disabled = false;
            buscandoCep = false;
            return;
        }

        // Preenche os campos automaticamente
        preencherCamposEndereco(data);

        // Armazena dados do CEP globalmente para usar na geocodificação
        window.dadosCep = {
            cidade: data.localidade,
            estado: data.uf,
            bairro: data.bairro
        };

        mostrarStatus(
            `✓ Endereço encontrado: ${data.logradouro}, ${data.bairro}, ${data.localidade}-${data.uf}`,
            'sucesso'
        );

        console.log('✅ CEP encontrado:', data);

        // Foca no próximo campo (complemento ou número)
        setTimeout(() => {
            const numeroInput = document.getElementById('numero');
            if (numeroInput) numeroInput.focus();
        }, 500);

        // Se o número já estiver preenchido, geocodifica automaticamente
        const numeroInput = document.getElementById('numero');
        if (numeroInput && numeroInput.value.trim()) {
            setTimeout(() => geocodificarEndereco(), 1000);
        }

    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        mostrarStatus('❌ Erro ao buscar CEP. Verifique sua conexão.', 'erro');
    } finally {
        cepInput.classList.remove('loading');
        cepInput.disabled = false;
        buscandoCep = false;
    }
}

/**
 * Preenche os campos de endereço com os dados do ViaCEP
 */
function preencherCamposEndereco(data) {
    const enderecoInput = document.getElementById('endereco');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');

    if (enderecoInput && data.logradouro) {
        enderecoInput.value = data.logradouro;
    }

    if (bairroInput && data.bairro) {
        bairroInput.value = data.bairro;
    }

    if (cidadeInput && data.localidade) {
        cidadeInput.value = data.localidade;
    }

    if (estadoInput && data.uf) {
        estadoInput.value = data.uf.toUpperCase();
    }
}

/**
 * Geocodifica o endereço completo para obter latitude e longitude
 */
async function geocodificarEndereco() {
    if (geocodificando) return; // Evita múltiplas requisições

    const enderecoInput = document.getElementById('endereco');
    const numeroInput = document.getElementById('numero');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');
    const cepInput = document.getElementById('cep');

    const endereco = enderecoInput?.value.trim();
    const numero = numeroInput?.value.trim();
    const bairro = bairroInput?.value.trim();
    const cidade = cidadeInput?.value.trim();
    const estado = estadoInput?.value.trim();
    const cep = cepInput?.value.replace(/\D/g, '');

    // Valida campos obrigatórios
    if (!endereco || !numero || !cidade || !estado || !cep || cep.length !== 8) {
        mostrarStatus('⚠️ Preencha todos os campos de endereço antes de buscar as coordenadas', 'erro');
        return;
    }

    geocodificando = true;

    // Adiciona classe de loading no campo número
    numeroInput.classList.add('loading');
    numeroInput.disabled = true;

    // Monta endereço completo para geocodificação
    const enderecoCompleto = montarEnderecoCompleto(endereco, numero, bairro, cidade, estado);

    mostrarStatus('🗺️ Buscando coordenadas no mapa...', 'info');

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
            // Preenche os campos hidden com as coordenadas
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');

            if (latitudeInput) latitudeInput.value = data[0].lat;
            if (longitudeInput) longitudeInput.value = data[0].lon;

            mostrarStatus(
                `✓ Coordenadas encontradas! Latitude: ${parseFloat(data[0].lat).toFixed(6)}, Longitude: ${parseFloat(data[0].lon).toFixed(6)}`,
                'sucesso'
            );

            console.log('✅ Geocodificação bem-sucedida:', data[0]);

            // Foca no próximo campo (hora início)
            setTimeout(() => {
                const horaInicioInput = document.getElementById('hora_inicio');
                if (horaInicioInput) horaInicioInput.focus();
            }, 500);

        } else {
            console.log('⚠️ Nenhum resultado retornado pela API');
            mostrarStatus(
                '⚠️ Coordenadas não encontradas. O ponto será cadastrado sem localização no mapa. Você pode ajustar o endereço e tentar novamente.',
                'erro'
            );
        }

    } catch (error) {
        console.error('Erro ao geocodificar:', error);
        mostrarStatus(
            '⚠️ Erro ao buscar coordenadas. O ponto será cadastrado sem localização no mapa.',
            'erro'
        );
    } finally {
        numeroInput.classList.remove('loading');
        numeroInput.disabled = false;
        geocodificando = false;
    }
}

/**
 * Monta o endereço completo para geocodificação
 */
function montarEnderecoCompleto(endereco, numero, bairro, cidade, estado) {
    let enderecoCompleto = `${endereco}, ${numero}`;

    if (bairro) {
        enderecoCompleto += `, ${bairro}`;
    }

    enderecoCompleto += `, ${cidade}, ${estado}, Brasil`;

    return enderecoCompleto;
}

/**
 * Mostra mensagem de status com estilo
 */
function mostrarStatus(mensagem, tipo) {
    const statusDiv = document.getElementById('geoStatus');

    if (!statusDiv) return;

    statusDiv.textContent = mensagem;
    statusDiv.className = 'geo-status';

    if (tipo === 'sucesso') {
        statusDiv.classList.add('geo-success');
    } else if (tipo === 'erro') {
        statusDiv.classList.add('geo-error');
    } else if (tipo === 'info') {
        statusDiv.classList.add('bg-blue-100', 'text-blue-700', 'border-l-4', 'border-blue-500');
    }

    statusDiv.classList.remove('hidden');

    // Remove mensagens de sucesso após 5 segundos
    if (tipo === 'sucesso') {
        setTimeout(() => {
            statusDiv.classList.add('hidden');
        }, 5000);
    }
}

/**
 * Validação do formulário antes de enviar
 */
function validarFormulario() {
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');

    const lat = latitudeInput?.value;
    const lng = longitudeInput?.value;

    // Aviso se as coordenadas não foram encontradas
    if (!lat || !lng) {
        return confirm(
            '⚠️ As coordenadas não foram encontradas automaticamente.\n\n' +
            'O ponto de coleta será cadastrado sem localização no mapa.\n\n' +
            'Deseja continuar mesmo assim?'
        );
    }

    return true;
}