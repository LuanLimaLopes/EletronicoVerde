<?php 
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../../Infrastructure/security/CSRF.php';
use EletronicoVerde\Infrastructure\Security\CSRF;

$csrf = new CSRF();
?>

<style>
    #form1{
        display: flex;
        flex-direction: column;
        gap: 2rem;
        align-items: center;
    }

    #form1 div{
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        width: 50rem;
    }

    @media (max-width: 1024px) {
        #form1 div{
          width: 30rem;
        }
    }

    #form1 div input, #form1 div select{
        border: 1px solid #4a5565;
        padding: 0.75rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    #form1 div input:focus, #form1 div select:focus{
        border-color: #04A777;
        box-shadow: 0 0 0 3px rgba(4, 167, 119, 0.1);
        outline: none;
    }

    #form1 div label{
        font-weight: bold;
        font-size: 1.125rem;
        color: var(--color-cinza-txt);
    }

    .btn_cad{
        background-color: var(--color-primary);
        color: white;
        padding: 0.8rem 10rem;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 2rem;
        font-size: 1.25rem;
        transition: 0.2s ease;
        border: 2px solid var(--color-primary);
    }

    .btn_cad:hover{
        background-color: var(--color-white);
        border: 2px solid var(--color-third);
        color: var(--color-third);
    }
    
    .geo-status {
        font-size: 0.875rem;
        padding: 0.75rem;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
        transition: all 0.3s ease;
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .geo-success {
        background-color: #d1fae5;
        color: #065f46;
        border-left: 4px solid #04A777;
    }
    
    .geo-error {
        background-color: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #dc2626;
    }
    
    /* Loader animado */
    .loading {
        position: relative;
        pointer-events: none;
        opacity: 0.6;
    }
    
    .loading::after {
        content: "";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #04A777;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }
</style>

<main class="relative z-2 bg-white rounded-b-[30px]">
  <div class="container mx-auto pt-30 pb-30 p-5">
    
    <?php if (isset($_SESSION['erro'])): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded pb-4">
        <?= htmlspecialchars($_SESSION['erro']) ?>
        <?php unset($_SESSION['erro']); ?>
      </div>
    <?php endif; ?>

    <div class="w-full flex items-center justify-between pb-10 flex-wrap">
      <div class="w-1/3">
        <a href="/eletronicoverde/acesso-restrito" class="relative transition-all duration-150 text-third font-bold p-1 text-xl hover:text-primary
          before:absolute before:h-[1px] before:w-0 hover:before:w-full before:bg-primary before:bottom-0 before:left-0 before:transition-all before:duration-150">
          <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
      </div>
      <div class="w-1/3 text-center">
        <h1 class="text-4xl font-bold">Cadastrar Ponto de Coleta</h1>
      </div>
      <div class="w-1/3"></div>
    </div>

    <form action="/eletronicoverde/pontos-coleta/salvar" method="POST" id="form1" onsubmit="return validarFormulario()">
      
      <?= $csrf->gerarCampoInput() ?>
      
      <div>
        <label for="empresa">Empresa</label>
        <input type="text" id="empresa" name="txtempresa" required>
      </div>
      
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="txtemail" required>
      </div>
      
      <div>
        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="txttelefone" placeholder="(00) 00000-0000" required>
      </div>

      <div>
        <label for="cep">CEP</label>
        <input type="text" id="cep" name="txtcep" placeholder="00000-000" required>
        <small class="text-gray-600">Digite o CEP e saia do campo para buscar automaticamente</small>
      </div>

      <div>
        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="txtendereco" required>
      </div>

      <div>
        <label for="complemento">Complemento</label>
        <input type="text" id="complemento" name="txtcomplemento">
      </div>

      <div>
        <label for="numero">Número</label>
        <input type="text" id="numero" name="txtnumero" required>
        <small class="text-gray-600">Preencha o número para buscar as coordenadas automaticamente</small>
      </div>

      <div>
        <label for="hora_inicio">Hora Início</label>
        <input type="time" id="hora_inicio" name="txthora_inicio" required>
      </div>

      <div>
        <label for="hora_encerrar">Hora Encerramento</label>
        <input type="time" id="hora_encerrar" name="txthora_encerrar" required>
      </div>
      
      <div>
        <label for="materiais">Materiais Aceitos</label>
        <select multiple name="materiais_ids[]" id="materiais" class="h-40" required>
          <?php foreach ($materiais as $material): ?>
            <option value="<?= $material->getId() ?>">
              <?= htmlspecialchars($material->getNome()) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <small class="text-gray-600">Segure Ctrl (Windows) ou Cmd (Mac) para selecionar múltiplos itens</small>
      </div>
      
      <!-- Campos hidden para coordenadas -->
      <input type="hidden" id="latitude" name="latitude">
      <input type="hidden" id="longitude" name="longitude">
      
      <div id="geoStatus" class="hidden geo-status"></div>

      <input type="submit" class="btn_cad" value="Cadastrar">
    </form>

  </div>
</main>

<script>
// Estado global para controlar requisições
let buscandoCep = false;
let geocodificando = false;

// Busca CEP automaticamente ao sair do campo
document.getElementById('cep').addEventListener('blur', async function() {
    const cep = this.value.replace(/\D/g, '');
    
    // Só busca se tiver 8 dígitos e não estiver buscando
    if (cep.length === 8 && !buscandoCep) {
        await buscarCep();
    }
});

// Geocodifica automaticamente ao preencher o número
document.getElementById('numero').addEventListener('blur', async function() {
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
document.getElementById('cep').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 5) {
        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
    }
    e.target.value = value;
});

// Formata telefone automaticamente
document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 10) {
        value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else {
        value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
    }
    e.target.value = value;
});

// Feedback visual nos campos enquanto estão sendo processados
document.getElementById('cep').addEventListener('focus', function() {
    this.style.borderColor = '#04A777';
});

document.getElementById('cep').addEventListener('blur', function() {
    this.style.borderColor = '#4a5565';
});

document.getElementById('numero').addEventListener('focus', function() {
    this.style.borderColor = '#04A777';
});

document.getElementById('numero').addEventListener('blur', function() {
    this.style.borderColor = '#4a5565';
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>