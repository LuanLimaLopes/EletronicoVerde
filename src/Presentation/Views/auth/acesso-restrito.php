<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="relative z-2 bg-white rounded-b-[30px]">

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

    <header class="w-full pt-20 sm:pt-0 h-[40vh] sm:h-[50vh] bg-fourth flex flex-col items-center z-1 relative">
        <div class="mx-auto container flex flex-col gap-2 justify-center h-full text-left px-4 fade-left">
            <p class="font-bold text-primary text-lg md:text-xl">ACESSO RESTRITO</p>
            <p class="max-w-full md:max-w-2/3 font-bold text-xl md:text-2xl lg:text-3xl lg:leading-13">
                Olá, <?= htmlspecialchars($nomeUsuario ?? 'Administrador') ?>! 
                Ambiente restrito para gestão dos pontos de coleta. Acesse com responsabilidade.
            </p>
        </div>
    </header>

    <div class="flex justify-center flex-col gap-6 items-center flex-wrap w-full min-h-[60vh] sm:min-h-[50vh] px-4 md:px-0 py-10 fade-section">
        <a href="/eletronicoverde/pontos-coleta/cadastro" class="bg-primary sm:w-[25rem] md:w-[30rem] text-white px-6 md:px-10 py-5 md:py-8 rounded-lg hover:bg-primary/80 transition font-bold text-md md:text-xl flex flex-row items-center justify-center gap-5">
            <i class="fa-solid fa-plus"></i> Cadastrar ponto de coleta
        </a>
        
        <a href="/eletronicoverde/consultar-pontos" class="bg-white sm:w-[25rem] md:w-[30rem] border-2 border-primary text-primary px-6 md:px-10 py-5 md:py-8 rounded-lg hover:bg-primary hover:text-white transition font-bold text-md md:text-xl flex flex-row items-center justify-center gap-5">
            <i class="fa-solid fa-list"></i> Consultar pontos de coleta
        </a>
        
        <a href="/eletronicoverde/logout" class="border border-red-500 w-fit text-red-500 px-6 md:px-10 py-5 mt-10 md:py-8 rounded-lg hover:bg-red-600 transition font-bold text-md md:text-lg flex flex-row items-center justify-center gap-5">
            <i class="fa-solid fa-right-from-bracket"></i> Sair
        </a>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>