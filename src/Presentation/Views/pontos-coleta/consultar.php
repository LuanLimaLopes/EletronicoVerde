<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="min-h-[100vh] relative z-2 bg-white">
    <div class="container mx-auto mt-30 p-5">
      
      <!-- Mensagens -->
      <?php if (isset($_SESSION['sucesso'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          <?= htmlspecialchars($_SESSION['sucesso']) ?>
          <?php unset($_SESSION['sucesso']); ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['erro'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <?= htmlspecialchars($_SESSION['erro']) ?>
          <?php unset($_SESSION['erro']); ?>
        </div>
      <?php endif; ?>

      <div class="w-full flex items-center justify-between mb-10 flex-wrap">
        <div class="w-1/3">
          <a href="/acesso-restrito" class="relative transition-all duration-150 text-third font-bold p-1 text-xl hover:text-primary 
                  before:absolute before:h-[1px] before:w-0 hover:before:w-full before:bg-primary before:bottom-0 before:left-0 before:transition-all before:duration-150">
            <i class="fa-solid fa-arrow-left"></i> Voltar
          </a>
        </div>
        <div class="w-1/3 text-center">
          <h1 class="text-4xl font-bold">Lista de Pontos de Coleta</h1>
        </div>
        <div class="w-1/3"></div>
      </div>

      <div class="overflow-x-auto">
        <?php if (!empty($pontosColeta)): ?>
            <table class="border-collapse w-full mt-5">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Email</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Materiais Aceitos</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold" colspan="2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pontosColeta as $ponto): ?>
                    <tr class="hover:bg-fourth transition-colors">
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['id']) ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['empresa']) ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['endereco']) ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['numero']) ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['complemento'] ?? '-') ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['cep']) ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['hora_inicio']) ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['hora_encerrar']) ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['telefone']) ?></td>
                        <td class="border border-gray-300 p-2"><?= htmlspecialchars($ponto['email']) ?></td>
                        <td class="border border-gray-300 p-2">
                            <?php if (!empty($ponto['materiais'])): ?>
                                <?php 
                                $materiais = array_map(function($m) { 
                                    return htmlspecialchars($m['nome']); 
                                }, $ponto['materiais']);
                                echo implode(', ', $materiais);
                                ?>
                            <?php else: ?>
                                <span class="text-gray-500">Nenhum</span>
                            <?php endif; ?>
                        </td>
                        <td class="border border-gray-300 p-0">
                            <a href="/editar-ponto?id=<?= $ponto['id'] ?>" 
                               class="block w-full h-full p-2 text-center text-azul font-bold hover:bg-blue-100 transition-colors">
                                Editar
                            </a>
                        </td>
                        <td class="border border-gray-300 p-0">
                            <a href="/excluir-ponto?id=<?= $ponto['id'] ?>" 
                               onclick="return confirm('Tem certeza que deseja excluir este ponto de coleta?')" 
                               class="block w-full h-full p-2 text-center text-red-500 font-bold hover:bg-red-100 transition-colors">
                                Excluir
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table> 
        <?php else: ?>
          <div class="text-center mt-20 flex flex-col items-center justify-center gap-5">
            <p class="text-xl">Nenhum ponto de coleta cadastrado.</p>
            <a href="/cadastro-pontos" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-second transition font-bold">
                Cadastrar Primeiro Ponto
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>primary text-black font-bold">ID</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Empresa</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Endereço</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Número</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Complemento</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">CEP</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Horário Início</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Horário Encerramento</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Telefone</th>
                        <th class="border border-gray-300 p-2 bg-primary text-black font-bold">Email</th>
                        <th class="border border-gray-300 p-2 bg-