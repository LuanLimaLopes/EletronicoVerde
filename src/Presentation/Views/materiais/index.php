<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiais</title>
    <?php require_once __DIR__ . '/../layouts/header.php'; ?>
    <style  type="text/tailwindcss">
@layer components {
  /* Estrutura principal */
  .mat-aceitos-div {
    @apply min-h-[40rem] w-full px-4;
  }

  /* Alterna o background nas seções ímpares */
  /* .mat-aceitos-div:nth-child(odd) {
    @apply bg-[#e6faf4] ;
  } */

  /* .mat-aceitos-div-2 - container flex (padrão row) */
  .mat-aceitos-div-2 {
    @apply mx-auto w-full flex flex-col md:flex-row h-full flex-wrap;
  }

  /* Nas seções ímpares, inverter a direção */
  /* .mat-aceitos-div:nth-child(odd) .mat-aceitos-div-2 {
    @apply flex-row-reverse ;
  } */

  /* Conteúdo da coluna (texto) */
  .mat-aceitos-div-content {
    @apply flex flex-col gap-4 w-full md:w-1/2 justify-center items-start;
  }

  /* Nas ímpares, alinhar o conteúdo ao fim */
  /* .mat-aceitos-div:nth-child(odd) .mat-aceitos-div-content {
    @apply items-end;
  } */

  /* Parágrafo dentro do content */
  .mat-aceitos-div-content p {
    @apply max-w-full md:max-w-[80%] font-bold text-[#333] text-left;
  }

  /* Parágrafos nas seções ímpares alinhados à direita */
  /* .mat-aceitos-div:nth-child(odd) .mat-aceitos-div-content p {
    @apply text-right;
  } */

  /* Título H2 */
  .mat-aceitos-div-content h2 {
    @apply text-3xl font-bold text-primary mb-4 flex flex-row items-center 
        gap-5 p-2 px-5 bg-[#d3fff252] border-[#d2d2d2cc] top-[6rem] w-fit rounded-2xl backdrop-blur-md ;
  }

  /* Ícone dentro do H2 */
  .mat-aceitos-div-content h2 i {
    @apply text-3xl md:text-5xl; /* equivalente a text-5xl (3rem) */
  }

  /* Grid de imagens */
  .mat-aceitos-div-imgs {
    @apply grid gap-4 grid-cols-2 grid-rows-2 w-full md:w-1/2 items-center;
  }

  .mat-aceitos-div-imgs div{
    @apply flex justify-center items-center w-full h-full;
  }

  .mat-aceitos-div-imgs div img {
    @apply max-h-full max-w-full rounded-[1rem];
  }

  .frase{
    color: #7f7f7f !important;
  }

  .hidden-filter{
    @apply opacity-0 hidden;
  }

  .filtro-btn.active{
    @apply bg-fourth text-black font-bold rounded-xl md:rounded-full px-4 py-2;
  }

  .filtro-btn{
    @apply transition-all h-full w-max duration-200 bg-transparent text-sm md:text-base border border-gray-300 text-cinza-txt px-4 py-2 rounded-xl md:rounded-full cursor-pointer flex flex-col items-center justify-center md:flex-row gap-2 hover:bg-fourth hover:text-black;
  }
  
}
</style>

</head>
<body>

<!-- HERO SECTION -->
<header class="w-full pt-20 sm:pt-0 h-[40vh] sm:h-[50vh] bg-fourth flex flex-col items-center z-1 relative">
    <div class="mx-auto container flex flex-col gap-2 justify-center h-full text-left px-4 fade-left">
        <p class="font-bold text-primary text-lg md:text-xl">MATERIAIS ACEITOS</p>
        <p class="max-w-full md:max-w-2/3 font-bold text-xl md:text-2xl lg:text-3xl lg:leading-13">
            Conheça os dispositivos que podem ser reciclados e contribua para um planeta mais limpo!
        </p>
    </div>
</header>

<!-- MAIN CONTENT -->
<!-- <section class="pt-[10rem] z-1 relative bg-white rounded-b-[30px] ">
    <div class="h-full gap-10 flex flex-col container mx-auto">
        <div class="container mx-auto fade-section">
            <p class="max-w-2/3 text-justify font-medium mb-[5rem] text-cinza-txt text-2xl">
                Para o descarte adequado de lixo eletrônico visando a reciclagem, 
                é importante saber o que pode ser aproveitado e como cada item deve ser descartado. 
                Alguns exemplos de eletrônicos que podem ser reciclados incluem:
            </p>
        </div>

        <div class="mat-aceitos-div rounded-3xl bg-emerald-400 p-5 fade-left">
            <div class=" mat-aceitos-div-2 fade-left bg-emerald-400 rounded-3xl">
                <div class="mat-aceitos-div-content jutify-center p-10 bg-white rounded-3xl ">
                    <h2 class="text-3xl text-emerald-400!">
                        <i class="fa-solid fa-computer"></i> Aparelhos eletrônicos
                    </h2>
                    <p class="text-lg lg:text-2xl">Celulares, tablets, computadores, notebooks, impressoras e televisores.</p>
                    <p class="text-base italic">Esses dispositivos contêm metais valiosos e componentes que podem ser reaproveitados, reduzindo o desperdício e a poluição.</p>
                </div>
                <div class="mat-aceitos-div-imgs  bg-emerald-400 h-full is-visible p-5">
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/celular2.webp" alt="Placa-mãe" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/computador.webp" alt="Processador" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/impressora.webp" alt="HD" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/televisao.webp" alt="Memória RAM" class="mat-aceitos-imgs" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div rounded-3xl bg-emerald-500 p-5 fade-left">
            <div class="mat-aceitos-div-2 fade-left bg-emerald-500 rounded-3xl">
                <div class="mat-aceitos-div-content jutify-center p-10 bg-white rounded-3xl ">
                    <h2 class="text-3xl text-emerald-500!">
                        <i class="fa-solid fa-microchip "></i> Componentes de computador
                    </h2>
                    <p class="text-lg lg:text-2xl">Placas-mãe, processadores, HDs, memórias RAM e placas de vídeo.</p>
                    <p class="text-base italic">Partes internas como placas e processadores possuem metais e materiais recicláveis que ajudam a economizar recursos naturais.</p>
                </div>
                <div class="mat-aceitos-div-imgs  bg-emerald-500 h-full is-visible p-5">
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/placa-mae.webp" alt="Placa-mãe" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/processador.webp" alt="Processador" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/hd.webp" alt="HD" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/memoria.webp" alt="Memória RAM" class="mat-aceitos-imgs" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div rounded-3xl bg-emerald-600 p-5 fade-left">
            <div class="mat-aceitos-div-2 fade-left bg-emerald-600 rounded-3xl">
                <div class="mat-aceitos-div-content jutify-center p-10 bg-white rounded-3xl">
                    <h2 class="text-3xl text-emerald-600!">
                        <i class="fa-solid fa-blender"></i> Eletrodomésticos
                    </h2>
                    <p class="text-lg lg:text-2xl">Micro-ondas, geladeiras, máquinas de lavar e fogões.</p>
                    <p class="text-base italic">Mesmo os eletrodomésticos antigos podem ter peças reaproveitadas e metais recicláveis que diminuem o impacto ambiental.</p>
                </div>

                <div class="mat-aceitos-div-imgs  bg-emerald-600 h-full is-visible p-5">
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/microondas.webp" alt="Placa-mãe" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/geladeira.webp" alt="Processador" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/lavadora.webp" alt="HD" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/fogao.webp" alt="Memória RAM" class="mat-aceitos-imgs" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div rounded-3xl bg-emerald-700 p-5 fade-left">
            <div class=" mat-aceitos-div-2 fade-left bg-emerald-700 rounded-3xl">
                <div class="mat-aceitos-div-content jutify-center p-10 bg-white rounded-3xl">
                    <h2 class="text-3xl text-emerald-700!">
                        <i class="fa-solid fa-battery-full"></i> Baterias e pilhas
                    </h2>
                    <p class="text-lg lg:text-2xl">Tanto de aparelhos eletrônicos quanto de dispositivos pequenos, como controle remoto.</p>
                    <p class="text-base italic">Esses itens contêm substâncias tóxicas que poluem o solo e a água, o descarte correto evita danos à natureza.</p>
                </div>
                <div class="mat-aceitos-div-imgs  bg-emerald-700! h-full is-visible p-5">
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/bateria.webp" alt="Placa-mãe" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/pilhas.webp" alt="Processador" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/carregador.webp" alt="HD" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/controle.webp" alt="Memória RAM" class="mat-aceitos-imgs" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div rounded-3xl bg-emerald-800 p-5 fade-left">
            <div class=" mat-aceitos-div-2 fade-left bg-emerald-800 rounded-3xl">
                <div class="mat-aceitos-div-content jutify-center p-10 bg-white rounded-3xl">
                    <h2 class="text-3xl text-emerald-800!">
                        <i class="fa-solid fa-plug"></i> Cabos e fios
                    </h2>
                    <p class="text-lg lg:text-2xl">Cabos de energia, carregadores, cabos USB e HDMI</p>
                    <p class="text-base italic">Cabos e fios possuem cobre e outros metais valiosos que podem ser recuperados e reutilizados na indústria.</p>
                </div>
                <div class="mat-aceitos-div-imgs  bg-emerald-800 h-full is-visible p-5">
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/cabo-energia.webp" alt="Placa-mãe" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/cabo-usb.webp" alt="Processador" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/cabo-hdmi.webp" alt="HD" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/carregador2.webp" alt="Memória RAM" class="mat-aceitos-imgs" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div rounded-3xl bg-emerald-900 p-5 fade-left">
            <div class=" mat-aceitos-div-2 fade-left bg-emerald-900 rounded-3xl">
                <div class="mat-aceitos-div-content jutify-center p-10 bg-white rounded-3xl">
                    <h2 class="text-3xl text-emerald-900!">
                        <i class="fa-solid fa-keyboard"></i> Acessórios e Periféricos
                    </h2>
                    <p class="text-lg lg:text-2xl">Fones de ouvido, mouses, teclados e relógios digitais.</p>
                    <p class="text-sm italic">Aparelhos menores também fazem diferença! Reciclar controles, fones e carregadores ajuda a reduzir o lixo eletrônico.</p>
                </div>
                <div class="mat-aceitos-div-imgs  bg-emerald-900 h-full is-visible p-5">
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/fone.webp" alt="Placa-mãe" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/mouse.webp" alt="Processador" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/teclado.webp" alt="HD" class="mat-aceitos-imgs" />
                    </div>
                    <div>
                        <img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/relogio.webp" alt="Memória RAM" class="mat-aceitos-imgs" />
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto fade-section">
            <p class="max-w-5/6 text-left font-medium py-[8rem] text-cinza-txt text-2xl">
                <b>Esses materiais contêm metais valiosos como cobre, alumínio, ouro e prata, além de plásticos que podem ser reaproveitados.</b> 
                No entanto, <b>componentes como baterias e placas eletrônicas</b> também carregam <b>substâncias tóxicas</b> (como chumbo e mercúrio), 
                que <b>devem ser descartados em pontos de coleta específicos</b> para evitar a contaminação ambiental. 
                <br><br>Antes de descartar, é importante <b>verificar se os dispositivos podem ser consertados ou doados</b>, pois isso também representa uma forma sustentável de lidar com o lixo eletrônico.
            </p>
        </div>
    </div>
</section> -->

<section class="pt-10 sm:pt-[10rem] z-1 relative bg-white rounded-b-[30px]">
    <div class="h-full flex flex-col gap-30">
        <div class="container mx-auto px-4 fade-section">
            <p class="max-w-full md:max-w-2/3 text-justify font-medium text-cinza-txt text-md md:text-xl lg:text-2xl">
                Para o descarte adequado de lixo eletrônico visando a reciclagem, 
                é importante saber o que pode ser aproveitado e como cada item deve ser descartado. 
                Alguns exemplos de eletrônicos que podem ser reciclados incluem:
            </p>
        </div>

        <div class="container mx-auto px-4 fade-section">
            <ul class="filtro-container flex flex-row overflow-x-auto space-x-4">
                <li><button class="filtro-btn active" data-filtro="todos">Todos</button></li>
                <li><button class="filtro-btn" data-filtro="aparelhos"><i class="fa-solid fa-computer"></i>Aparelhos eletrônicos</button></li>
                <li><button class="filtro-btn" data-filtro="componentes"><i class="fa-solid fa-microchip"></i>Componentes de computador</button></li>
                <li><button class="filtro-btn" data-filtro="eletrodomesticos"><i class="fa-solid fa-blender"></i>Eletrodomésticos</button></li>
                <li><button class="filtro-btn" data-filtro="pilhas"><i class="fa-solid fa-battery-full"></i>Baterias e pilhas</button></li>
                <li><button class="filtro-btn" data-filtro="cabos"><i class="fa-solid fa-plug"></i>Cabos e fios</button></li>
                <li><button class="filtro-btn" data-filtro="acessorios"><i class="fa-solid fa-keyboard"></i>Acessórios e Periféricos</button></li>
            </ul>
        </div>
        
        <div class="mat-aceitos-div card" data-filter-item="aparelhos">
            <div class="container mx-auto mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content ">
                    <h2 class="text-xl lg:text-3xl"><i class="fa-solid fa-computer"></i> Aparelhos eletrônicos</h2>
                    <p class="text-lg lg:text-2xl">Celulares, tablets, computadores, notebooks, impressoras e televisores.</p>

                    <div class="overflow-hidden transition-all duration-500 max-h-0" id="list-aparelhos">
                        <ul class="grid grid-cols-2 gap-2 text-sm md:text-lg list-disc list-inside gap-x-5 bg-whitey text-black p-5 rounded-xl">
                            <li>Celulares e smartphones</li>
                            <li>Tablets</li>
                            <li>Notebooks e ultrabooks</li>
                            <li>Monitores</li>
                            <li>Televisores e telas em geral</li>
                            <li>Consoles de videogame</li>
                            <li>Controles remotos</li>
                            <li>Câmeras digitais e filmadoras</li>
                            <li>Roteadores e modems</li>
                            <li>Aparelhos de som e DVD players</li>
                            <li>Impressoras e scanners</li>
                            <li>Calculadoras eletrônicas</li>
                        </ul>
                    </div>

                    <button class="text-second hover:bg-third hover:text-white p-3 rounded-3xl transition-all duration-200 text-base cursor-pointer font-bold mb-2" data-target="list-aparelhos">
                        Ver mais itens <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-300"></i>
                    </button>

                    <p class="text-base italic frase">Esses dispositivos contêm metais valiosos e componentes que podem ser reaproveitados, reduzindo o desperdício e a poluição.</p>
                </div>
                <div class="mat-aceitos-div-imgs ">
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/celular2.webp" alt="Celular" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/computador.webp" alt="Computador" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/impressora.webp" alt="Impressora" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/televisao.webp" alt="Televisão" class="mat-aceitos-imgs" /></div>
                </div>
            </div>            
        </div>      

        <div class="mat-aceitos-div card" data-filter-item="componentes">
            <div class="container mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content ">
                    <h2 class="text-xl lg:text-3xl"><i class="fa-solid fa-microchip"></i> Componentes de computador</h2>
                    <p class="text-lg lg:text-2xl">Placas-mãe, processadores, HDs, memórias RAM e placas de vídeo.</p>

                    <div class="overflow-hidden transition-all duration-500 max-h-0" id="list-componentes">
                        <ul class="grid grid-cols-2 gap-2 text-sm md:text-lg list-disc list-inside gap-x-5 bg-whitey text-black p-5 rounded-xl">
                            <li>Placa-mãe</li>
                            <li>Memória RAM</li>
                            <li>HD e SSDs</li>
                            <li>Fonte</li>
                            <li>Cooler</li>
                            <li>Gabinete</li>
                            <li>Drives de CD/DVD</li>
                            <li>Gabinetes e carcaças de computador</li>
                            <li>Placas de rede e som</li>
                            <li>Cabos internos de computador</li>
                        </ul>
                    </div>

                    <button class="text-second hover:bg-third hover:text-white p-3 rounded-3xl transition-all duration-200 text-base cursor-pointer font-bold mb-2" data-target="list-componentes">
                        Ver mais itens <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-300"></i>
                    </button>

                    <p class="text-base italic frase">Partes internas como placas e processadores possuem metais e materiais recicláveis que ajudam a economizar recursos naturais.</p>
                </div>
                <div class="mat-aceitos-div-imgs ">
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/placa-mae.webp" alt="Placa-mãe" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/processador.webp" alt="Processador" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/hd.webp" alt="HD" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/memoria.webp" alt="Memória RAM" class="mat-aceitos-imgs" /></div>
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div card" data-filter-item="eletrodomesticos">
            <div class="container mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content">
                    <h2 class="text-xl lg:text-3xl"><i class="fa-solid fa-blender"></i> Eletrodomésticos</h2>
                    <p class="text-lg lg:text-2xl">Micro-ondas, geladeiras, máquinas de lavar e fogões.</p>

                    <div class="overflow-hidden transition-all duration-500 max-h-0" id="list-eletrodomesticos">
                        <ul class="grid grid-cols-2 gap-2 text-sm md:text-lg list-disc list-inside gap-x-5 bg-whitey text-black p-5 rounded-xl">
                            <li>Liquidificadores</li>
                            <li>Batedeiras</li>
                            <li>Cafeteiras elétricas</li>
                            <li>Ferro de passar</li>
                            <li>Secadores de cabelo</li>
                            <li>Chapinhas</li>
                            <li>Ventiladores</li>
                            <li>Aparelhos de barbear</li>
                            <li>Torradeiras</li>
                            <li>Micro-ondas</li>
                            <li>Aspiradores de pó</li>
                            <li>Sanduicheiras</li>
                        </ul>
                    </div>

                    <button class="text-second hover:bg-third hover:text-white p-3 rounded-3xl transition-all duration-200 text-base cursor-pointer font-bold mb-2" data-target="list-eletrodomesticos">
                        Ver mais itens <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-300"></i>
                    </button>

                    <p class="text-base italic frase">Mesmo os eletrodomésticos antigos podem ter peças reaproveitadas e metais recicláveis que diminuem o impacto ambiental.</p>
                </div>
                <div class="mat-aceitos-div-imgs ">
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/microondas.webp" alt="Micro-ondas" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/geladeira.webp" alt="Geladeira" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/lavadora.webp" alt="Máquina de lavar" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/fogao.webp" alt="Fogão" class="mat-aceitos-imgs" /></div>
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div card" data-filter-item="pilhas">
            <div class="container mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content">
                    <h2 class="text-xl lg:text-3xl"><i class="fa-solid fa-battery-full"></i> Baterias e pilhas</h2>
                    <p class="text-lg lg:text-2xl">Tanto de aparelhos eletrônicos quanto de dispositivos pequenos, como controle remoto.</p>

                    <div class="overflow-hidden transition-all duration-500 max-h-0" id="list-pilhas">
                        <ul class="grid grid-cols-2 gap-2 text-sm md:text-lg list-disc list-inside gap-x-5 bg-whitey text-black p-5 rounded-xl">
                            <li>Pilhas comuns</li>
                            <li>Baterias de celular</li>
                            <li>Baterias de notebook</li>
                            <li>Baterias recarregáveis</li>
                            <li>Baterias de câmeras fotográficas</li>
                            <li>Powerbanks</li>
                            <li>Baterias de controle remoto e relógios</li>
                            <li>Baterias de drones e brinquedos eletrônicos</li>
                        </ul>
                    </div>

                    <button class="text-second hover:bg-third hover:text-white p-3 rounded-3xl transition-all duration-200 text-base cursor-pointer font-bold mb-2" data-target="list-pilhas">
                        Ver mais itens <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-300"></i>
                    </button>

                    <p class="text-base italic frase">Esses itens contêm substâncias tóxicas que poluem o solo e a água, o descarte correto evita danos à natureza.</p>
                </div>
                <div class="mat-aceitos-div-imgs ">
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/bateria.webp" alt="Bateria" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/pilhas.webp" alt="Pilhas" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/carregador.webp" alt="Carregador" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/controle.webp" alt="Controle" class="mat-aceitos-imgs" /></div>
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div card" data-filter-item="cabos">
            <div class="container mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content">
                    <h2 class="text-xl lg:text-3xl"><i class="fa-solid fa-plug"></i> Cabos e fios</h2>
                    <p class="text-lg lg:text-2xl">Cabos de energia, carregadores, cabos USB e HDMI</p>

                    <div class="overflow-hidden transition-all duration-500 max-h-0" id="list-cabos">
                        <ul class="grid grid-cols-2 gap-2 text-sm md:text-lg list-disc list-inside gap-x-5 bg-whitey text-black p-5 rounded-xl">
                            <li>Cabos USB</li>
                            <li>Cabos HDMI</li>
                            <li>Cabos de energia elétrica</li>
                            <li>Cabos de rede (Ethernet)</li>
                            <li>Cabos de áudio e vídeo</li>
                            <li>Cabos de carregadores</li>
                            <li>Extensões e réguas de energia</li>
                            <li>Fios elétricos cortados ou inutilizados</li>
                        </ul>
                    </div>

                    <button class="text-second hover:bg-third hover:text-white p-3 rounded-3xl transition-all duration-200 text-base cursor-pointer font-bold mb-2" data-target="list-cabos">
                        Ver mais itens <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-300"></i>
                    </button>
                    
                    <p class="text-base italic frase">Cabos e fios possuem cobre e outros metais valiosos que podem ser recuperados e reutilizados na indústria.</p>
                </div>
                <div class="mat-aceitos-div-imgs ">
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/cabo-energia.webp" alt="Cabo de energia" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/cabo-usb.webp" alt="Cabo USB" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/cabo-hdmi.webp" alt="Cabo HDMI" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/carregador2.webp" alt="Carregador" class="mat-aceitos-imgs" /></div>
                </div>
            </div>
        </div>

        
        <div class="mat-aceitos-div card" data-filter-item="acessorios">
            <div class="container mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content">
                    <h2 class="text-xl lg:text-3xl"><i class="fa-solid fa-keyboard"></i> Acessórios e Periféricos</h2>
                    <p class="text-lg lg:text-2xl">Fones de ouvido, mouses, teclados e relógios digitais.</p>

                    <div class="overflow-hidden transition-all duration-500 max-h-0" id="list-acessorios">
                        <ul class="grid grid-cols-2 gap-2 text-sm md:text-lg list-disc list-inside gap-x-5 bg-whitey text-black p-5 rounded-xl">
                            <li>Teclados</li>
                            <li>Mouses</li>
                            <li>Fones de ouvido e headsets</li>
                            <li>Microfones</li>
                            <li>Webcams</li>
                            <li>Pen drives</li>
                            <li>Cartões de memória</li>
                            <li>Controles de videogame</li>
                            <li>Caixas de som externas</li>
                            <li>Hubs USB</li>
                            <li>Adaptadores e conversores</li>
                            <li>Smartwatches</li>
                        </ul>
                    </div>

                    <button class="text-second hover:bg-third hover:text-white p-3 rounded-3xl transition-all duration-200 text-base cursor-pointer font-bold mb-2" data-target="list-acessorios">
                        Ver mais itens <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-300"></i>
                    </button>

                    <p class="text-sm italic frase">Aparelhos menores também fazem diferença! Reciclar controles, fones e carregadores ajuda a reduzir o lixo eletrônico.</p>
                </div>
                <div class="mat-aceitos-div-imgs ">
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/fone.webp" alt="Fone de ouvido" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/mouse.webp" alt="Mouse" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/teclado.webp" alt="Teclado" class="mat-aceitos-imgs" /></div>
                    <div><img src="<?= ASSETS_URL ?>/images/MateriaisAceitos/relogio.webp" alt="Relógio" class="mat-aceitos-imgs" /></div>
                </div>
            </div>
        </div>  

        <div class="container mx-auto fade-section px-4">
            <p class="max-w-full md:max-w-5/6 text-left font-medium py-30 text-cinza-txt text-md md:text-xl lg:text-2xl">
                <b>Esses materiais contêm metais valiosos como cobre, alumínio, ouro e prata, além de plásticos que podem ser reaproveitados.</b> 
                No entanto, <b>componentes como baterias e placas eletrônicas</b> também carregam <b>substâncias tóxicas</b> (como chumbo e mercúrio), 
                que <b>devem ser descartados em pontos de coleta específicos</b> para evitar a contaminação ambiental. 
                <br><br>Antes de descartar, é importante <b>verificar se os dispositivos podem ser consertados ou doados</b>, pois isso também representa uma forma sustentável de lidar com o lixo eletrônico.
            </p>
        </div>
    </div>
</section>

<script>

document.addEventListener('DOMContentLoaded', () => {
    // 1. Seleciona todos os botões de filtro e os itens de conteúdo
    const filterButtons = document.querySelectorAll('.filtro-btn');
    const contentItems = document.querySelectorAll('[data-filter-item]'); // Seleciona todas as divs de conteúdo

    // 2. Adiciona o listener de clique para cada botão
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const selectedFilter = button.getAttribute('data-filtro');

            // Atualiza o estado "active" dos botões
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // 3. Itera sobre os itens de conteúdo para aplicar a filtragem
            contentItems.forEach(item => {
                const itemCategory = item.getAttribute('data-filter-item');
                
                // Lógica de filtro:
                // Se o filtro for 'todos' OU a categoria do item for igual ao filtro selecionado
                if (selectedFilter === 'todos' || itemCategory === selectedFilter) {
                    // MOSTRA o item (Remove a classe de ocultação)
                    item.classList.remove('hidden-filter');
                    
                    // Opcional: Para manter as animações de rolagem (fade-left/fade-section) funcionando 
                    // em alguns frameworks, pode ser necessário re-inicializá-las aqui.
                    // Se você não tiver problemas de animação, ignore esta linha.
                    item.style.opacity = 1; 

                } else {
                    // OCULTA o item (Adiciona a classe de ocultação)
                    // Adicionamos um pequeno atraso para que a transição de opacidade seja visível antes do display:none
                    item.classList.add('hidden-filter');
                }
            });

            // 4. (Opcional) Rolagem suave para o primeiro item após o filtro, se houver scrollbar
            // Isso evita que o usuário fique 'perdido' na parte inferior da página após filtrar.
            document.querySelector('.filtro-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    document.querySelectorAll('button[data-target]').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = document.getElementById(btn.dataset.target);
        const expanded = target.classList.toggle('max-h-200');
        btn.innerHTML = expanded ? 'Ver menos <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-300 rotate-180"></i>' : 'Ver mais itens <i class="fa-solid fa-chevron-down ml-2 transition-transform duration-300"></i>';
      });
    });

});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

</body>
</html>







