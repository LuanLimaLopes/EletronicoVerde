<?php 
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../../Infrastructure/security/CSRF.php';
use EletronicoVerde\Infrastructure\Security\CSRF;

$csrf = new CSRF();

?>

<main class="relative z-2 bg-white rounded-b-[30px]">
    <div class="container mx-auto pt-20 pb-30 p-5">
      
        <!-- Mensagens de Erro -->
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($_SESSION['erro']) ?>
                <?php unset($_SESSION['erro']); ?>
            </div>
        <?php endif; ?>

        <div class="w-full flex items-center justify-between pb-10 flex-wrap">
          <div class="w-1/3">
            <a href="/eletronicoverde/consultar-pontos" class="relative transition-all duration-150 text-third font-bold p-1 text-xl hover:text-primary
                    before:absolute before:h-[1px] before:w-0 hover:before:w-full before:bg-primary before:bottom-0 before:left-0 before:transition-all before:duration-150">
                <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
          </div>
          <div class="w-1/3 text-center">
            <h1 class="text-4xl font-bold">Editar Ponto de Coleta</h1>
          </div>
          <div class="w-1/3"></div>
        </div>

        <form method="post" action="/eletronicoverde/ponto-coleta/atualizar" id="form1" class="flex flex-col gap-8 items-center">
            
            <!-- Token CSRF -->
            <?= $csrf->gerarCampoInput() ?>
            
            <!-- ID Hidden -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($pontoColeta['id']) ?>">

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="empresa" class="font-bold text-lg text-cinza-txt">Empresa</label>
                <input type="text" id="empresa" name="txtempresa" 
                       value="<?= htmlspecialchars($pontoColeta['empresa']) ?>" 
                       required class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="endereco" class="font-bold text-lg text-cinza-txt">Endereço</label>
                <input type="text" id="endereco" name="txtendereco" 
                       value="<?= htmlspecialchars($pontoColeta['endereco']) ?>" 
                       required class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="numero" class="font-bold text-lg text-cinza-txt">Número</label>
                <input type="text" id="numero" name="txtnumero" 
                       value="<?= htmlspecialchars($pontoColeta['numero']) ?>" 
                       required class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="complemento" class="font-bold text-lg text-cinza-txt">Complemento</label>
                <input type="text" id="complemento" name="txtcomplemento" 
                       value="<?= htmlspecialchars($pontoColeta['complemento'] ?? '') ?>" 
                       class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="cep" class="font-bold text-lg text-cinza-txt">CEP</label>
                <input type="text" id="cep" name="txtcep" 
                       value="<?= htmlspecialchars($pontoColeta['cep']) ?>" 
                       required class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="hora_inicio" class="font-bold text-lg text-cinza-txt">Horário Início</label>
                <input type="time" id="hora_inicio" name="txthora_inicio" 
                       value="<?= htmlspecialchars($pontoColeta['hora_inicio']) ?>" 
                       required class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="hora_encerrar" class="font-bold text-lg text-cinza-txt">Horário Encerramento</label>
                <input type="time" id="hora_encerrar" name="txthora_encerrar" 
                       value="<?= htmlspecialchars($pontoColeta['hora_encerrar']) ?>" 
                       required class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="telefone" class="font-bold text-lg text-cinza-txt">Telefone</label>
                <input type="text" id="telefone" name="txttelefone" 
                       value="<?= htmlspecialchars($pontoColeta['telefone']) ?>" 
                       required class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="email" class="font-bold text-lg text-cinza-txt">Email</label>
                <input type="email" id="email" name="txtemail" 
                       value="<?= htmlspecialchars($pontoColeta['email']) ?>" 
                       required class="border border-gray-600 p-3 rounded-xl">
            </div>

            <div class="flex flex-col gap-2 lg:w-[50rem] md:w-[30rem] w-full">
                <label for="materiais" class="font-bold text-lg text-cinza-txt">Materiais Aceitos</label>
                <select multiple name="materiais_ids[]" id="materiais" 
                        class="border-2 border-gray-600 p-3 rounded-xl w-full h-40">
                    <?php 
                    $materiaisSelecionados = array_column($pontoColeta['materiais'] ?? [], 'id');
                    foreach ($materiais as $material): 
                    ?>
                        <option value="<?= $material->getId() ?>" 
                                <?= in_array($material->getId(), $materiaisSelecionados) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($material->getNome()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-gray-600">Segure Ctrl (Windows) ou Cmd (Mac) para selecionar múltiplos itens</small>
            </div>

            <button type="submit" class="bg-primary hover:bg-second text-white py-3 px-40 font-bold text-xl rounded-lg transition-all mt-5">
                Salvar Alterações
            </button>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>