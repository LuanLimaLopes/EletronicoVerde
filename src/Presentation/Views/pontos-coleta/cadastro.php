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

    @media (max-width: 768px) {
        #form1 div{
          width: -webkit-fill-available;
        }
    }

    @media (max-width: 640px) {
        #form1 div{
          width: -webkit-fill-available;
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
        box-shadow: 0 0 0 4px #04A77750;
        outline: none;


    }

    #form1 div input:disabled {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }

    #form1 div label{
        font-weight: bold;
        font-size: 1.125rem;
        color: var(--color-cinza-txt);
    }

    @media (max-width: 1024px) {
        #form1 div label{
          font-size: 1rem;
        }
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

    @media (max-width: 768px) {
        .btn_cad{
          padding: 1rem;
          width: -webkit-fill-available;
          font-size: 1.125rem ;
        }
    }

    /* @media (max-width: 640px) {
        .btn_cad{
          padding: 0.3rem 5rem;
          font-size: 0.875rem;
        }
    } */
    
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

    <div class="w-full flex flex-col md:flex-row items-center justify-between pb-10 flex-wrap">
      <div class="w-1/3 flex justify-center mb-20 md:mb-0">
        <a href="/eletronicoverde/acesso-restrito" class="relative transition-all duration-150 text-third font-bold p-1 text-xl hover:text-primary
          before:absolute before:h-px before:w-0 hover:before:w-full before:bg-primary before:bottom-0 before:left-0 before:transition-all before:duration-150">
          <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
      </div>
      <div class="w-full md:w-1/3 text-center">
        <h1 class="text-2xl md:text-3xl font-bold">Cadastrar Ponto de Coleta</h1>
      </div>
      <div class="hidden md:flex w-1/3"></div>
    </div>

    <form action="/eletronicoverde/pontos-coleta/salvar" method="POST" id="form1" onsubmit="return validarFormulario()">
      
      <?= $csrf->gerarCampoInput() ?>
      
      <div>
        <label for="empresa">Empresa</label>
        <input type="text" id="empresa" name="txtempresa" placeholder="Nome da empresa" required>
      </div>
      
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="txtemail" placeholder="contato@empresa.com" required>
      </div>
      
      <div>
        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="txttelefone" placeholder="(00) 00000-0000" maxlength="15" required>
      </div>

      <div>
        <label for="cep">CEP</label>
        <input type="text" id="cep" name="txtcep" placeholder="00000-000" maxlength="9" required>
        <small class="text-gray-600">Digite o CEP e saia do campo para buscar automaticamente</small>
      </div>

      <div>
        <label for="endereco">Endereço (Rua)</label>
        <input type="text" id="endereco" name="txtendereco" placeholder="Avenida Exemplo" required>
      </div>

      <div>
        <label for="bairro">Bairro</label>
        <input type="text" id="bairro" name="txtbairro" placeholder="Centro"  required>
      </div>

      <div>
        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="txtcidade" placeholder="São Paulo" required>
      </div>

      <div>
        <label for="estado">Estado (UF)</label>
        <input type="text" id="estado" name="txtestado" maxlength="2" placeholder="SP" required>
      </div>

      <div>
        <label for="complemento">Complemento</label>
        <input type="text" id="complemento" name="txtcomplemento" placeholder="Opcional (bloco, sala, loja...)">
      </div>

      <div>
        <label for="numero">Número</label>
        <input type="text" id="numero" name="txtnumero" placeholder="123" required>
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
        <select multiple name="materiais_ids[]" id="materiais" class="h-fit" required>
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


<script src="/eletronicoverde/scripts/geocode_pontos.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>