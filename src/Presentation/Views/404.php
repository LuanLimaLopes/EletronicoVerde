<?php require_once __DIR__ . '/layouts/header.php'; ?>

    <main class="w-full min-h-[100vh] rounded-b-[30px] flex flex-col justify-center items-center text-center py-20 gap-15 p-6 bg-whitey relative z-10" >
        <h1 class="text-6xl font-bold italic">404 - Página não encontrada</h1>
        <p class="text-3xl ">A página que você está procurando não existe.</p>
        <a href="<?= BASE_URL ?>/index.php" class="bg-primary text-2xl text-white p-4 w-fit h-fit rounded-3xl rounded-tl-none border-2 border-primary relative overflow-hidden z-1
        hover:rounded-tr-sm hover:rounded-tl-3xl hover:text-primary transition-all duration-150
        before:absolute before:h-full before:-z-1 before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-250">
        Voltar para a página inicial</a>
    </main>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>