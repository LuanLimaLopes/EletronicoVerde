<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="relative z-2 bg-white">

    <!-- inicia a sessão -->
    <?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] !== true) {
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
    ?>
    
    <!-- Mensagens de Sucesso/Erro -->
    <?php if (isset($_SESSION['sucesso'])): ?>
        <div class="container mx-auto mt-5">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($_SESSION['sucesso']) ?>
                <?php unset($_SESSION['sucesso']); ?>
            </div>
        </div>
    <?php endif; ?>

    <header class="w-full min-h-[50vh] h-[30rem] bg-fourth flex flex-col items-center z-1 relative">
        <div class="mx-auto container flex flex-col gap-2 justify-center h-full text-left">
            <p class="font-bold text-primary text-xl">ACESSO RESTRITO</p>
            <p class="max-w-2/3 font-bold text-4xl leading-13">
                Olá, <?= htmlspecialchars($nomeUsuario ?? 'Administrador') ?>! 
                Ambiente restrito para gestão dos pontos de coleta. Acesse com responsabilidade.
            </p>
        </div>
    </header>

    <div class="flex justify-center gap-6 items-center flex-wrap w-full min-h-[50vh] py-10">
        <a href="/cadastro-pontos" class="bg-primary text-white px-10 py-8 rounded-lg hover:bg-primary/80 transition font-bold text-xl flex flex-row items-center justify-center gap-5">
            <i class="fa-solid fa-plus"></i> Cadastrar ponto de coleta
        </a>
        
        <a href="/consultar-pontos" class="bg-white border-2 border-primary text-primary px-10 py-8 rounded-lg hover:bg-primary hover:text-white transition font-bold text-xl flex flex-row items-center justify-center gap-5">
            <i class="fa-solid fa-list"></i> Consultar pontos de coleta
        </a>
        
        <a href="/logout" class="bg-red-500 text-white px-10 py-8 rounded-lg hover:bg-red-600 transition font-bold text-xl flex flex-row items-center justify-center gap-5">
            <i class="fa-solid fa-right-from-bracket"></i> Sair
        </a>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>