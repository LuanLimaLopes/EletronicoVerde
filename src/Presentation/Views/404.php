<?php require_once __DIR__ . '/layouts/header.php'; ?>


    <main class="w-full min-h-[100vh] rounded-b-[30px] flex flex-col justify-center items-center text-center py-20 gap-15 p-6 bg-whitey relative z-10" >

        <model-viewer src="<?= ASSETS_URL ?>/source/walle with textures.glb"
            src="assets/models/eletronico.glb"
            alt="Modelo 3D eletrônico"
            auto-rotate
            
            disable-zoom
            rotation-per-second="60deg"
            id="modelo"
            camera-orbit="60deg 75deg"
            style="width: 350px; height: 350px;">
        </model-viewer>

        <h1 class="text-[50em] absolute font-bold opacity-20 left-0 top-0 text-primary -z-2">404</h1>
        <h1 class="text-6xl font-bold italic">Página não encontrada</h1>
        <p class="text-3xl ">A página que você está procurando não existe.</p>
        <a href="<?= BASE_URL ?>/index.php" class="bg-primary text-2xl text-white p-4 w-fit h-fit rounded-3xl rounded-tl-none border-2 border-primary relative overflow-hidden z-1
        hover:rounded-tr-sm hover:rounded-tl-3xl hover:text-primary transition-all duration-150
        before:absolute before:h-full before:-z-1 before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-250">
        Voltar para a página inicial</a>

        
    </main>

    <script>
        const modelo = document.getElementById('modelo');

        modelo.addEventListener('load', () => {
            modelo.setAttribute('auto-rotate', ''); // só começa a girar depois do carregamento
        });
</script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>