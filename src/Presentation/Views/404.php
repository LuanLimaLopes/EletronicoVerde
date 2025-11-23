<?php require_once __DIR__ . '/layouts/header.php'; ?>


    <main class="w-full min-h-screen rounded-b-[30px] flex flex-col justify-center text-center py-20 gap-15 p-6 bg-whitey relative z-10" >
        <div class="w-full h-full absolute top-0 left-0 flex justify-center items-center flex-col overflow-hidden -z-1">
            <div class="flex flex-col w-fit h-fit justify-center items-center relative">        
                <h1 class="text-[50vw] sm:text-[50vw] md:text-[40vw] lg:text-[25vw] -z-2 flex justify-center items-center absolute w-full">4 <span class="opacity-0">0</span>4</h1>
                <model-viewer src="<?= ASSETS_URL ?>/source/walle with textures.glb"
                    alt="Modelo 3D eletrônico"
                    auto-rotate

                    disable-zoom
                    rotation-per-second="20deg"
                    id="modelo"
                    camera-orbit="60deg 75deg"
                    style="z-index: 1; display: block; top: 50%; left: 50%; transform: translate(-50%, -50%);"
                    class="w-[90vw] h-[90vw] sm:w-[70vw] sm:h-[70vw] md:w-[50vw] md:h-[50vw] lg:w-[30vw] lg:h-[30vw]">
                </model-viewer>
            </div>
            <div class="flex flex-col gap-10 justify-center items-center relative z-10">
                <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-cinza-txt">A página que você está procurando não existe.</p>
                <a href="/eletronicoverde" class="bg-primary font-bold text-md sm:text-lg md:text-xl lg:text-2xl text-white p-4 w-fit h-fit rounded-3xl rounded-tl-none border-2 border-primary relative overflow-hidden z-1
                hover:rounded-tr-sm hover:rounded-tl-3xl hover:text-primary transition-all duration-150
                before:absolute before:h-full before:-z-1 before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-250">
                Voltar para a página inicial</a>
            </div>

        </div>
        
    </main>

    <script>
        const modelo = document.getElementById('modelo');

        modelo.addEventListener('load', () => {
            modelo.setAttribute('auto-rotate', ''); // só começa a girar depois do carregamento
        });
</script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>