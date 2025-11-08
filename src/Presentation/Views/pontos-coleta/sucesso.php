<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="relative z-2 mx-auto pt-30 pb-30 p-5 rounded-b-[30px] bg-whitey h-[100vh] flex flex-col items-center justify-center">
    <div class="flex flex-col items-center justify-center min-h-[60vh] gap-8">
        
        <!-- Ícone de Sucesso -->
        <div class="text-primary text-8xl">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        
        <!-- Mensagem -->
        <h1 class="text-4xl font-bold text-center">
            <?php if (isset($_SESSION['sucesso'])): ?>
                <?= htmlspecialchars($_SESSION['sucesso']) ?>
                <?php unset($_SESSION['sucesso']); ?>
            <?php else: ?>
                Operação realizada com sucesso!
            <?php endif; ?>
        </h1>
        
        <!-- Botões de Ação -->
        <div class="flex gap-4 flex-wrap justify-center">
            <a href="/eletronicoverde/acesso-restrito" class="bg-primary text-white flex flex-row items-center justify-center gap-3 px-8 py-3 rounded-lg font-bold hover:bg-second transition-all">
                <i class="fa-solid fa-home"></i> Voltar ao Painel
            </a>
            
            <a href="/eletronicoverde/pontos-coleta/cadastro" class="bg-white border-2 border-primary text-primary flex flex-row items-center justify-center gap-5 px-8 py-3 rounded-lg font-bold hover:bg-primary hover:text-white transition-all">
                <i class="fa-solid fa-plus"></i> Cadastrar Outro Ponto
            </a>
            
            <a href="/eletronicoverde/consultar-pontos" class="bg-white border-2 border-second text-second flex flex-row items-center justify-center gap-5 px-8 py-3 rounded-lg font-bold hover:bg-second hover:text-white transition-all">
                <i class="fa-solid fa-list"></i> Ver Todos os Pontos
            </a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>