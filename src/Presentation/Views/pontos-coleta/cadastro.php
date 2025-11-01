
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
        transition: background-color 0.2s ease;
    }

    .btn_cad:hover{
        background-color: var(--color-second);
    }
</style>

<main class="relative z-2 bg-white">
  <div class="container mx-auto mt-30 pb-30 p-5">
    
    <!-- Mensagens de Erro/Sucesso -->
    <?php if (isset($_SESSION['erro'])): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($_SESSION['erro']) ?>
        <?php unset($_SESSION['erro']); ?>
      </div>
    <?php endif; ?>

    <div class="w-full flex items-center justify-between mb-10 flex-wrap">
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

    <form action="/eletronicoverde/pontos-coleta/salvar" method="POST" id="form1">
      
      <!-- Token CSRF -->
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

      <input type="submit" class="btn_cad" value="Cadastrar">
    </form>

  </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>