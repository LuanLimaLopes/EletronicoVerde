<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../Infrastructure/security/CSRF.php';
require_once __DIR__ . '/../layouts/header.php'; 

use EletronicoVerde\Infrastructure\Security\CSRF;

$csrf = new CSRF();
?>


<main class="relative z-2 bg-white rounded-b-[30px]">
    <div class="container mx-auto p-5 flex flex-col items-center justify-center min-h-screen">
        
        <!-- Mensagens de Erro -->
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 w-full max-w-md">
                <?= htmlspecialchars($_SESSION['erro']) ?>
                <?php unset($_SESSION['erro']); ?>
            </div>
        <?php endif; ?>

        <h1 class="text-4xl font-bold text-center mb-15">Entrar</h1>
        
        <form action="/eletronicoverde/login" method="post" class="flex flex-col gap-2 items-center lg:w-[50rem] md:w-[30rem] w-full">
            
            <!-- Token CSRF -->
            <?= $csrf->gerarCampoInput() ?>
            
            <label for="username" class="font-bold text-lg w-full text-cinza-txt">Usuário</label>
            <input type="text" id="username" name="username" required class="border border-gray-600 p-3 rounded-xl w-full mb-5">
            
            <label for="password" class="font-bold text-lg w-full text-cinza-txt">Senha</label>
            <input type="password" id="password" name="password" required class="border border-gray-600 p-3 rounded-xl w-full mb-20">
            
            <button type="submit" class="text-white bg-primary py-3 px-40 font-bold text-xl w-fit rounded-lg hover:bg-second transition-all">
                Entrar
            </button>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>