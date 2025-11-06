<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style  type="text/tailwindcss">
@layer components {
  /* Estrutura principal */
  .mat-aceitos-div {
    @apply h-[50rem] min-h-[90vh] w-full;
  }

  /* Alterna o background nas seções ímpares */
  .mat-aceitos-div:nth-child(odd) {
    @apply bg-[#e6faf4] ;
  }

  /* .mat-aceitos-div-2 - container flex (padrão row) */
  .mat-aceitos-div-2 {
    @apply mx-auto w-full flex flex-row h-full content-center flex-wrap;
  }

  /* Nas seções ímpares, inverter a direção */
  .mat-aceitos-div:nth-child(odd) .mat-aceitos-div-2 {
    @apply flex-row-reverse ;
  }

  /* Conteúdo da coluna (texto) */
  .mat-aceitos-div-content {
    @apply flex flex-col gap-4 w-1/2 justify-center items-start;
  }

  /* Nas ímpares, alinhar o conteúdo ao fim */
  .mat-aceitos-div:nth-child(odd) .mat-aceitos-div-content {
    @apply items-end;
  }

  /* Parágrafo dentro do content */
  .mat-aceitos-div-content p {
    @apply max-w-[80%] font-bold text-[#333] text-left;
  }

  /* Parágrafos nas seções ímpares alinhados à direita */
  .mat-aceitos-div:nth-child(odd) .mat-aceitos-div-content p {
    @apply text-right;
  }

  /* Título H2 */
  .mat-aceitos-div-content h2 {
    @apply flex items-center gap-8 max-w-[80%] font-black text-[var(--color-primary)];
  }

  /* Ícone dentro do H2 */
  .mat-aceitos-div-content h2 i {
    @apply text-[3rem]; /* equivalente a text-5xl (3rem) */
  }

  /* Grid de imagens */
  .mat-aceitos-div-imgs {
    @apply grid gap-4 grid-cols-2 h-[80%] w-1/2;
  }

  .mat-aceitos-div-imgs img {
    @apply h-full w-full object-cover rounded-[1rem];
  }

}
</style>


<!-- HERO SECTION -->
<header class="w-full h-[50vh] bg-fourth flex flex-col items-center z-1 relative">
    <div class="mx-auto container flex flex-col gap-2 justify-center h-full text-left 
    fade-left">
        <p class="font-bold text-primary text-xl">MATERIAIS ACEITOS</p>
        <p class="max-w-2/3 font-bold text-4xl leading-13">
            Conheça os dispositivos que podem ser reciclados e contribua para um planeta mais limpo!
        </p>
    </div>
</header>

<!-- MAIN CONTENT -->
<section class="pt-[10rem] z-1 relative bg-white">
    <div class="h-full">
        <div class="container mx-auto fade-section">
            <p class="max-w-2/3 text-justify font-medium mb-[5rem] text-cinza-txt text-2xl">
                Para o descarte adequado de lixo eletrônico visando a reciclagem, 
                é importante saber o que pode ser aproveitado e como cada item deve ser descartado. 
                Alguns exemplos de eletrônicos que podem ser reciclados incluem:
            </p>
        </div>

        <!-- Materiais Aceitos -->
        <div class="mat-aceitos-div ">
            <div class="container mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content ">
                    <h2 class="text-3xl">
                        <i class="fa-solid fa-computer"></i> Aparelhos eletrônicos
                    </h2>
                    <p class="text-2xl">Celulares, tablets, computadores, notebooks, impressoras e televisores.</p>
                    <p class="text-md italic">Esses dispositivos contêm metais valiosos e componentes que podem ser reaproveitados, reduzindo o desperdício e a poluição.</p>
                </div>
                <div class="mat-aceitos-div-imgs zoom-in">
                    <img src="/assets/images/celular.png" alt="Celular" class="mat-aceitos-imgs" />
                    <img src="/assets/images/computador.png" alt="Computador" class="mat-aceitos-imgs" />
                    <img src="/assets/images/impressora.png" alt="Impressora" class="mat-aceitos-imgs" />
                    <img src="/assets/images/televisao.png" alt="Televisão" class="mat-aceitos-imgs" />
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div ">
            <div class="container mat-aceitos-div-2 fade-right">
                <div class="mat-aceitos-div-content ">
                    <h2 class="text-3xl">
                        <i class="fa-solid fa-microchip"></i> Componentes de computador
                    </h2>
                    <p class="text-2xl">Placas-mãe, processadores, HDs, memórias RAM e placas de vídeo.</p>
                    <p class="text-md italic">Partes internas como placas e processadores possuem metais e materiais recicláveis que ajudam a economizar recursos naturais.</p>
                </div>
                <div class="mat-aceitos-div-imgs zoom-in">
                    <img src="/assets/images/placa-mae.png" alt="Placa-mãe" class="mat-aceitos-imgs" />
                    <img src="/assets/images/processador.png" alt="Processador" class="mat-aceitos-imgs" />
                    <img src="/assets/images/hd.png" alt="HD" class="mat-aceitos-imgs" />
                    <img src="/assets/images/memoria.png" alt="Memória RAM" class="mat-aceitos-imgs" />
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div ">
            <div class="container mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content">
                    <h2 class="text-3xl">
                        <i class="fa-solid fa-blender"></i> Eletrodomésticos
                    </h2>
                    <p class="text-2xl">Micro-ondas, geladeiras, máquinas de lavar e fogões.</p>
                    <p class="text-md italic">Mesmo os eletrodomésticos antigos podem ter peças reaproveitadas e metais recicláveis que diminuem o impacto ambiental.</p>
                </div>

                <div class="mat-aceitos-div-imgs zoom-in">
                    <img src="/assets/images/microondas.png" alt="Micro-ondas" class="mat-aceitos-imgs" />
                    <img src="/assets/images/geladeira.png" alt="Geladeira" class="mat-aceitos-imgs" />
                    <img src="/assets/images/lavadora.png" alt="Máquina de lavar" class="mat-aceitos-imgs" />
                    <img src="/assets/images/fogao.png" alt="Fogão" class="mat-aceitos-imgs" />
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div ">
            <div class="container mat-aceitos-div-2 fade-right">
                <div class="mat-aceitos-div-content">
                    <h2 class="text-3xl">
                        <i class="fa-solid fa-battery-full"></i> Baterias e pilhas
                    </h2>
                    <p class="text-2xl">Tanto de aparelhos eletrônicos quanto de dispositivos pequenos, como controle remoto.</p>
                    <p class="text-md italic">Esses itens contêm substâncias tóxicas que poluem o solo e a água, o descarte correto evita danos à natureza.</p>
                </div>
                <div class="mat-aceitos-div-imgs zoom-in">
                    <img src="/assets/images/bateria.png" alt="Bateria" class="mat-aceitos-imgs" />
                    <img src="/assets/images/pilhas.png" alt="Pilhas" class="mat-aceitos-imgs" />
                    <img src="/assets/images/carregador.png" alt="Carregador" class="mat-aceitos-imgs" />
                    <img src="/assets/images/controle.png" alt="Controle" class="mat-aceitos-imgs" />
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div ">
            <div class="container mat-aceitos-div-2 fade-left">
                <div class="mat-aceitos-div-content">
                    <h2 class="text-3xl">
                        <i class="fa-solid fa-plug"></i> Cabos e fios
                    </h2>
                    <p class="text-2xl">Cabos de energia, carregadores, cabos USB e HDMI</p>
                    <p class="text-md italic">Cabos e fios possuem cobre e outros metais valiosos que podem ser recuperados e reutilizados na indústria.</p>
                </div>
                <div class="mat-aceitos-div-imgs zoom-in">
                    <img src="/assets/images/cabo-energia.png" alt="Cabo de energia" class="mat-aceitos-imgs" />
                    <img src="/assets/images/cabo-usb.png" alt="Cabo USB" class="mat-aceitos-imgs" />
                    <img src="/assets/images/cabo-hdmi.png" alt="Cabo HDMI" class="mat-aceitos-imgs" />
                    <img src="/assets/images/carregador2.png" alt="Carregador" class="mat-aceitos-imgs" />
                </div>
            </div>
        </div>

        <div class="mat-aceitos-div ">
            <div class="container mat-aceitos-div-2 fade-right">
                <div class="mat-aceitos-div-content">
                    <h2 class="text-3xl">
                        <i class="fa-solid fa-keyboard"></i> Pequenos eletrônicos
                    </h2>
                    <p class="text-2xl">Fones de ouvido, mouses, teclados e relógios digitais.</p>
                    <p class="text-sm italic">Aparelhos menores também fazem diferença! Reciclar controles, fones e carregadores ajuda a reduzir o lixo eletrônico.</p>
                </div>
                <div class="mat-aceitos-div-imgs zoom-in">
                    <img src="/assets/images/fone.png" alt="Fone de ouvido" class="mat-aceitos-imgs" />
                    <img src="/assets/images/mouse.png" alt="Mouse" class="mat-aceitos-imgs" />
                    <img src="/assets/images/teclado.png" alt="Teclado" class="mat-aceitos-imgs" />
                    <img src="/assets/images/relogio.png" alt="Relógio" class="mat-aceitos-imgs" />
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
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>