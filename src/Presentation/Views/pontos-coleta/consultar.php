<head>
  <Title>Consultar Ponto de Coleta - Eletrônico Verde</Title>
</head>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="min-h-screen relative z-2 bg-white rounded-b-[30px]">
    <div class="container mx-auto py-30 p-5">
      <?php
        // --- CONFIGURAÇÃO DE PAGINAÇÃO ---
        $itensPorPagina = 10;

        // 1. Determinar a página atual (lê da URL, ex: ?pagina=2)
        $paginaAtual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($paginaAtual < 1) {
            $paginaAtual = 1;
        }

        // 2. Calcular o número total de itens e páginas
        $totalItens = count($pontosColeta);
        $totalPaginas = ceil($totalItens / $itensPorPagina);

        // 3. Garantir que a página atual não exceda o total
        if ($paginaAtual > $totalPaginas) {
            $paginaAtual = $totalPaginas > 0 ? $totalPaginas : 1;
        }

        // 4. Calcular o offset (ponto de partida para a fatia)
        $offset = ($paginaAtual - 1) * $itensPorPagina;

        // 5. Fatiar o array para obter apenas os itens da página atual
        $pontosParaExibir = array_slice($pontosColeta, $offset, $itensPorPagina);

        // 6. Atualiza o loop foreach para usar o novo array fatiado
        // O loop foreach deve ser alterado de:
        // <?php foreach ($pontosColeta as $ponto): ?\>
        // Para:
        // <?php foreach ($pontosParaExibir as $ponto): ?\>

      ?>
      <!-- Mensagens -->
      <?php if (isset($_SESSION['sucesso'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded pb-4 my-10">
          <?= htmlspecialchars($_SESSION['sucesso']) ?>
          <?php unset($_SESSION['sucesso']); ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['erro'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded pb-4 my-10">
          <?= htmlspecialchars($_SESSION['erro']) ?>
          <?php unset($_SESSION['erro']); ?>
        </div>
      <?php endif; ?>

      <div class="w-full flex flex-col md:flex-row items-center justify-between pb-10 flex-wrap">
        <div class="w-1/3 flex justify-center mb-20 md:mb-0">
            <a href="/EletronicoVerde/acesso-restrito" class="relative transition-all duration-150 text-third font-bold p-1 text-xl hover:text-primary
              before:absolute before:h-px before:w-0 hover:before:w-full before:bg-primary before:bottom-0 before:left-0 before:transition-all before:duration-150">
              <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
        </div>
        <div class="w-full md:w-1/3 text-center">
          <h1 class="text-2xl md:text-3xl font-bold">Lista de Pontos de Coleta</h1>
        </div>
        <div class="hidden md:flex w-1/3"></div>
      </div>

      <div class="overflow-x-auto">
        <?php if (!empty($pontosColeta)): ?>
            <div class="overflow-x-auto bg-white rounded-xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-white bg-primary">
                            <th class="px-4 py-3 font-semibold text-sm rounded-tl-xl sticky top-0 left-0 bg-primary">ID</th>
                            <th class="px-4 py-3 font-semibold text-sm">Empresa</th>
                            <th class="px-4 py-3 font-semibold text-sm">Endereço</th>
                            <th class="px-4 py-3 font-semibold text-sm">Número</th>
                            <th class="px-4 py-3 font-semibold text-sm">Comp.</th>
                            <th class="px-4 py-3 font-semibold text-sm">CEP</th>
                            <th class="px-4 py-3 font-semibold text-sm">Início</th>
                            <th class="px-4 py-3 font-semibold text-sm">Encerramento</th>
                            <th class="px-4 py-3 font-semibold text-sm">Telefone</th>
                            <th class="px-4 py-3 font-semibold text-sm">Email</th>
                            <th class="px-4 py-3 font-semibold text-sm">Materiais Aceitos</th>
                            <th class="px-4 py-3 font-semibold text-sm text-center rounded-tr-xl" colspan="2">Ações</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($pontosParaExibir as $ponto): ?>
                        <tr class="border-b border-gray-100 hover:bg-green-50/50 transition-colors duration-200">
                            <td class="px-4 py-3 text-sm text-gray-700 font-medium sticky top-0 left-0 bg-white"><?= htmlspecialchars($ponto['id']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-900 font-semibold"><?= htmlspecialchars($ponto['empresa']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($ponto['endereco']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($ponto['numero']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-500"><?= htmlspecialchars($ponto['complemento'] ?? '-') ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($ponto['cep']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($ponto['hora_inicio']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($ponto['hora_encerrar']) ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($ponto['telefone']) ?></td>
                            <td class="px-4 py-3 text-sm text-primary hover:underline cursor-pointer"><?= htmlspecialchars($ponto['email']) ?></td>
                        
                            <td class="px-4 py-2 text-sm">
                                <?php if (!empty($ponto['materiais'])): ?>
                                    <?php 
                                        $materiais = array_map(fn($m) => htmlspecialchars($m['nome']), $ponto['materiais']);
                                        $materiais_exibidos = array_slice($materiais, 0, 3); // Exibe apenas os 3 primeiros
                                        $materiais_restantes = count($materiais) - 3;
                                    ?>
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        <?php foreach ($materiais_exibidos as $material): ?>
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full whitespace-nowrap">
                                                <?= $material ?>
                                            </span>
                                        <?php endforeach; ?>
                                        
                                        <?php if ($materiais_restantes > 0): ?>
                                            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2 py-0.5 rounded-full whitespace-nowrap cursor-pointer hover:bg-gray-200" title="<?= implode(', ', array_slice($materiais, 3)) ?>">
                                                +<?= $materiais_restantes ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs italic">Não especificado</span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="p-0 w-16 text-center">
                                <a href="/EletronicoVerde/editar-ponto?id=<?= $ponto['id'] ?>" 
                                    class="block p-5 text-blue-600 hover:text-blue-900 transition-colors"
                                    title="Editar Ponto">
                                    <i class="fa-solid fa-pen-to-square fa-lg"></i> 
                                </a>
                            </td>
                            <td class="p-0 w-16 text-center">
                                <a href="/EletronicoVerde/excluir-ponto?id=<?= $ponto['id'] ?>" 
                                    onclick="return confirm('Tem certeza que deseja excluir este ponto de coleta?')" 
                                    class="block p-5 text-red-600 hover:text-red-900 transition-colors"
                                    title="Excluir Ponto">
                                    <i class="fa-solid fa-trash fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if ($totalPaginas > 1): ?>
                    <div class="flex items-center gap-10 flex-col mt-8 p-4">
                        
                        
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="?pagina=<?= $paginaAtual - 1 ?>"
                              class="<?= $paginaAtual <= 1 ? 'pointer-events-none opacity-50' : '' ?> relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>

                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <a href="?pagina=<?= $i ?>"
                                  class="<?= $i == $paginaAtual ? 'z-10 bg-primary border-primary text-white font-semibold' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' ?> relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <a href="?pagina=<?= $paginaAtual + 1 ?>"
                              class="<?= $paginaAtual >= $totalPaginas ? 'pointer-events-none opacity-50' : '' ?> relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </nav>

                        <div class="text-sm text-gray-700">
                            Exibindo <?= count($pontosParaExibir) ?> de <?= $totalItens ?> pontos de coleta.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
 
        <?php else: ?>
          <div class="text-center pt-20 flex flex-col items-center justify-center gap-5">
            <p class="text-xl">Nenhum ponto de coleta cadastrado.</p>
            <a href="/EletronicoVerde/pontos-coleta/cadastro" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-second transition font-bold flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i>Cadastrar ponto de Coleta
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; 