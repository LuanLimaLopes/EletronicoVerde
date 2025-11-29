<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style type="text/tailwindcss">
    .titulo-secao{
        @apply font-bold text-primary mb-4 flex flex-row items-center text-left
        gap-5 sticky p-2 px-5 bg-[#d3fff252] border-[#d2d2d2cc] top-[6rem] w-fit rounded-2xl backdrop-blur-md z-10;
    }

    .texto-secao{
        @apply text-gray-700 leading-7 ;
    }
    
    .secao-content{
        @apply flex flex-col justify-center text-justify px-4 gap-[24px];
    }

    .metodos{
        @apply list-decimal flex flex-col gap-5 pl-5 text-gray-700 leading-7;
    }

    .dicas-text {
        @apply text-gray-700 leading-7 list-disc pl-5;
    }

    .dicas-text-ul{
        @apply list-none pl-0 text-gray-700 leading-7 flex flex-col gap-5;
    }

</style>

<style>
    .maleficios-card div{
        height: -webkit-fill-available;
    }
</style>

<header class="w-full pt-20 sm:pt-0 h-[40vh] sm:h-[50vh] bg-fourth flex flex-col items-center z-1 relative">
    <div class="mx-auto container flex flex-col gap-2 justify-center h-full text-left px-4 fade-left">
        <p class="font-bold text-primary text-lg md:text-xl">RECICLAGEM</p>
        <p class="max-w-full lg:max-w-2/3 font-bold text-xl md:text-2xl lg:text-3xl lg:leading-13">
            Reciclar eletrônicos é cuidar do planeta: descubra os benefícios, 
            evite os danos do descarte incorreto e aprenda como fazer a sua parte 
            para um futuro mais sustentável.
        </p>
    </div>
</header>

<section class=" z-1 relative bg-white rounded-b-[30px]">
    <div class="hidden lg:flex justify-end absolute h-full w-full top-0 left-0 z-1 pointer-events-none">
        <model-viewer src="<?= ASSETS_URL ?>/source/leaf3.glb"
            alt="Bota velha com broto de planta"
            auto-rotate
            disable-tap
            disable-zoom
            class="fade-up sticky top-70 left-0 mb-120 z-0"
            auto-rotate-delay="0"
            rotation-per-second="0deg"
            id="bota-3d"
            camera-orbit="10deg 80deg"
            data-initial-orbit="10deg 80deg"
            style="width: 350px; height: 350px;">
        </model-viewer>
    </div>

    <div class="pt-10 sm:pt-[5rem] h-full flex flex-col gap-30">
        
        <!-- Benefícios da Reciclagem -->
        <div class="container mx-auto secao-content ">
            <h1 class="titulo-secao max-w-full lg:max-w-2/3 text-xl md:text-2xl lg:text-3xl fade-up ">
                <i class="fa-solid fa-leaf text-3xl lg:text-5xl"></i>Benefícios da reciclagem do lixo eletrônico
            </h1>
            <p class="texto-secao max-w-full lg:max-w-2/3 text-justify font-medium text-cinza-txt text-md md:text-lg lg:text-xl fade-up">
                <b>A reciclagem do lixo eletrônico traz diversos benefícios significativos para o meio ambiente, a saúde pública e a economia</b>.<br><br>

                Primeiramente, <b>ela reduz o impacto ambiental</b>. Dispositivos eletrônicos, como celulares, computadores e eletrodomésticos, contêm materiais tóxicos, como chumbo e mercúrio, que podem contaminar o solo e a água se descartados incorretamente. <b>Reciclar esses produtos impede a liberação dessas substâncias nocivas</b>, preservando o meio ambiente.<br><br>

                Além disso, a reciclagem <b>contribui para a conservação de recursos naturais</b>. Equipamentos eletrônicos são compostos por metais preciosos, como ouro e prata, e outros materiais valiosos. Reciclar permite que esses materiais sejam recuperados e reutilizados, <b>diminuindo a necessidade de extrair novos recursos</b>, um benefício tanto para a natureza quanto para a economia.<br><br>

                A reciclagem do lixo eletrônico <b>gera empregos</b> e fortalece a economia circular. O processo de coleta, triagem e reciclagem cria oportunidades de trabalho em diferentes setores, <b>movimentando a economia local</b> e promovendo um modelo de produção e consumo mais sustentável.<br><br>

                Por fim, <b>a conscientização sobre a reciclagem</b> de eletrônicos incentiva hábitos mais responsáveis entre os consumidores. Ao compreenderem a importância do descarte correto, as pessoas se tornam mais engajadas em práticas sustentáveis.
            </p>
        </div>       

        <!-- Malefícios do Descarte Incorreto -->
        <div class=" container mx-auto secao-content ">
            <h1 class="titulo-secao max-w-full lg:max-w-2/3 text-xl md:text-2xl lg:text-3xl fade-up ">
                <i class="fa-solid fa-triangle-exclamation text-3xl lg:text-5xl"></i>Malefícios do descarte incorreto do lixo eletrônico
            </h1>
            <p class="texto-secao max-w-full lg:max-w-2/3 text-justify font-medium text-cinza-txt text-md md:text-lg lg:text-xl fade-up">
                <b>O descarte incorreto de lixo eletrônico traz sérios malefícios tanto para o meio ambiente quanto para a saúde humana</b>. Dispositivos como celulares, computadores e baterias contêm substâncias tóxicas, como chumbo, mercúrio e cádmio, que, quando descartados em locais inadequados,<b> podem contaminar o solo, lençóis freáticos e até o ar</b>. Essa poluição afeta negativamente a fauna, a flora e as comunidades próximas a aterros ou áreas de descarte, causando um impacto ambiental duradouro.<br><br>

                Além dos danos ao meio ambiente, o descarte incorreto <b>representa um desperdício de recursos valiosos</b>, como ouro, prata e cobre, que poderiam ser reciclados e reaproveitados. A reciclagem de eletrônicos permite a recuperação desses metais, <b>reduzindo a necessidade de extração de novos recursos naturais</b>, o que ajuda a minimizar os danos ao planeta.<br><br>

                <b>Os riscos à saúde humana</b> também são significativos. A exposição prolongada às substâncias tóxicas presentes nos eletrônicos pode causar problemas graves, como distúrbios neurológicos, doenças respiratórias e até câncer, afetando especialmente os trabalhadores que manuseiam esses materiais de forma inadequada.
            </p>
            
            <div class="maleficios-card flex flex-col sm:flex-row items-center gap-5 mt-5 max-w-full h-fit lg:max-w-2/3 zoom-in" >
                <div class="flex flex-col justify-center items-center border-2 border-third text-third font-bold rounded-2xl p-3 md:p-5 bg-white gap-7 flex-1 w-full sm:w-1/3 fade-up">
                    <i class="fa-solid fa-coins text-3xl lg:text-4xl"></i>
                    <p class="sm:text-md md:text-lg text-center">Reciclar uma tonelada de celulares pode recuperar cerca de 340 gramas de ouro.</p>
                </div>
                
                <div class="flex flex-col justify-center items-center border-2 border-second text-second font-bold rounded-2xl p-3 md:p-5 bg-white gap-7 flex-1 w-full sm:w-1/3 fade-up">
                    <i class="fa-solid fa-globe text-3xl lg:text-4xl"></i>
                    <p class="sm:text-md md:text-lg text-center">Apenas 17% do lixo eletrônico é reciclado no mundo. O restante polui o planeta!</p>
                </div>

                <div class="flex flex-col justify-center items-center border-2 border-primary text-primary font-bold rounded-2xl p-3 md:p-5 bg-white gap-7 flex-1 w-full sm:w-1/3 fade-up">
                    <i class="fa-solid fa-mobile-screen text-3xl lg:text-4xl"></i>
                    <p class="sm:text-md md:text-lg text-center">Você sabia que um único celular pode conter até 60 tipos de metais diferentes?</p>
                </div>
            </div>
        </div>

        <!-- Como Ajudar a Reciclar -->
        <div class=" container mx-auto secao-content ">
            <h1 class="titulo-secao max-w-full lg:max-w-2/3 text-xl md:text-2xl lg:text-3xl fade-up">
                <i class="fa-solid fa-recycle text-3xl lg:text-5xl"></i>Como ajudar a reciclar o lixo eletrônico
            </h1>
            <p class="texto-secao max-w-full lg:max-w-2/3 text-justify font-medium text-cinza-txt text-md md:text-lg lg:text-xl fade-up">
                <b>7 Métodos Eficazes para o Descarte Correto de Lixo Eletrônico</b>
                <ol class="metodos max-w-full lg:max-w-2/3 text-md md:text-lg lg:text-xl fade-up">
                    <li><b>Centros de Coleta Especializados</b>: Estes locais são preparados para garantir que o e-lixo seja reciclado de forma segura e responsável, evitando a contaminação ambiental.</li>
                    <li><b>Programas de Devolução</b>: Algumas lojas e fabricantes aceitam eletrônicos antigos ao comprar novos, assegurando que esses dispositivos sejam corretamente reciclados ou reutilizados.</li>
                    <li><b>Campanhas de Reciclagem</b>: Iniciativas públicas ou privadas que incentivam a conscientização, promovem eventos de coleta e educam sobre a importância do descarte adequado.</li>
                    <li><b>Doação</b>: Equipamentos ainda em funcionamento podem ser doados para instituições de caridade, escolas ou organizações que precisam de dispositivos eletrônicos.</li>
                    <li><b>Reciclagem de Fabricantes</b>: Muitas empresas possuem programas de retorno, permitindo que você devolva produtos antigos para reciclagem direta por meio do fabricante.</li>
                    <li><b>Recicladores Certificados</b>: Recicladores que seguem normas ambientais rigorosas garantem que o e-lixo seja tratado com segurança, sem prejudicar o meio ambiente.</li>
                    <li><b>Serviços de Coleta para Empresas</b>: Para grandes volumes de resíduos, serviços especializados de coleta e reciclagem são uma solução prática para empresas e indústrias.</li>
                </ol>
            </p>
            <p class="texto-secao max-w-full lg:max-w-2/3 text-justify font-medium text-cinza-txt text-md md:text-lg lg:text-xl fade-up mt-5">
                Esses métodos não só minimizam os impactos ambientais, mas também promovem a sustentabilidade ao reduzir o desperdício e reutilizar materiais valiosos. A <b>conscientização e a responsabilidade coletiva</b> são essenciais para garantir um futuro mais sustentável.
            </p>
        </div>  

        <!-- Estatísticas -->
        <div class=" container mx-auto secao-content ">
            <h1 class="titulo-secao max-w-full lg:max-w-2/3 text-xl md:text-2xl lg:text-3xl fade-up">
                <i class="fa-solid fa-chart-simple text-3xl lg:text-5xl"></i>Estatísticas
            </h1>
            <p class="texto-secao max-w-full lg:max-w-2/3 text-justify font-medium text-cinza-txt text-md md:text-lg lg:text-xl fade-up">
                O aumento do lixo eletrônico é uma preocupação global crescente. Em 2021, o mundo gerou <b>57,4 milhões de toneladas</b> de e-lixo, e a previsão é que esse número chegue a <b>74 milhões de toneladas</b> até 2030 (Fonte: Global E-Waste Monitor 2020). Infelizmente, apenas 17,4% de todo o lixo eletrônico produzido em 2019 foi reciclado de maneira adequada, demonstrando a necessidade urgente de melhorar as práticas de reciclagem (Fonte: Global E-Waste Monitor 2020).<br><br>

                Além da quantidade crescente, o impacto ambiental do lixo eletrônico é devastador. Estima-se que ele contenha até <b>1.000 substâncias tóxicas</b>, incluindo metais pesados e produtos químicos que poluem o solo e as fontes de água (Fonte: United Nations University). O descarte inadequado desses resíduos não só prejudica o meio ambiente, mas também representa um risco à saúde pública.<br><br>

                Se não tomarmos medidas mais eficazes, a inação no tratamento do e-lixo pode resultar em até <b>US$ 62,5 bilhões</b> em danos ambientais e sociais até 2025 (Fonte: World Economic Forum). Isso inclui custos de limpeza ambiental, tratamento de saúde e perda de materiais valiosos que poderiam ser reciclados.<br><br>

                Por outro lado, <b>66% dos consumidores</b> afirmam que prefeririam devolver seus dispositivos antigos para programas de reciclagem, caso tivessem essa opção disponível (Fonte: Electronics TakeBack Coalition). Esse dado destaca a importância de criar mais programas acessíveis e conscientizar a população sobre o descarte correto.
            </p>
        </div>        

        <!-- Dicas para Reciclar -->
        <div class=" container mx-auto secao-content ">
            <h1 class="titulo-secao max-w-full lg:max-w-2/3 text-xl md:text-2xl lg:text-3xl fade-up">
                <i class="fa-solid fa-lightbulb text-3xl lg:text-5xl"></i>Dicas para reciclar
            </h1>
            <div class="texto-secao max-w-full lg:max-w-2/3 text-justify font-medium text-cinza-txt text-md md:text-lg lg:text-xl fade-up">
                <ul class="dicas-text-ul text-md md:text-lg lg:text-xl"> 
                    <li><b>Proteção de Dados</b>
                        <ul class="dicas-text text-md md:text-lg lg:text-xl">
                            <li>Apague seus dados pessoais e remova itens perigosos: Antes de descartar, limpe completamente seus dispositivos eletrônicos e remova pilhas, baterias e cartuchos de tinta, descartando-os em locais apropriados.</li>
                        </ul>
                    </li>

                    <li><b>Manuseio Seguro de Componentes</b>
                        <ul class="dicas-text text-md md:text-lg lg:text-xl">
                            <li>Desmonte e descarte corretamente: Retire baterias, cabos e componentes pequenos e leve a centros de reciclagem. Evite armazenar dispositivos quebrados por muito tempo para prevenir riscos.</li>
                        </ul>
                    </li>

                    <li><b>Escolha Locais Certificados</b>
                        <ul class="dicas-text text-md md:text-lg lg:text-xl">
                            <li>Verifique o destino dos resíduos: Opte por centros de reciclagem certificados e garanta que seus eletrônicos não sejam descartados de forma inadequada, principalmente componentes perigosos como monitores CRT e lâmpadas fluorescentes.</li>
                        </ul>
                    </li>

                    <li><b>Aproveitamento de Componentes</b>
                        <ul class="dicas-text text-md md:text-lg lg:text-xl">
                            <li>Reutilize ou doe eletrônicos em bom estado: Doe, revenda ou reutilize componentes que ainda estejam funcionando. Verifique se fabricantes possuem programas de retorno para reciclar seus produtos.</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Impacto Positivo -->
        <div class=" container mx-auto secao-content ">
            <h1 class="titulo-secao max-w-full lg:max-w-2/3 text-xl md:text-2xl lg:text-3xl fade-up">
                <i class="fa-solid fa-face-smile text-3xl lg:text-5xl"></i>Impacto positivo para o futuro
            </h1>
            <p class="texto-secao max-w-full lg:max-w-2/3 text-justify font-medium text-cinza-txt text-md md:text-lg lg:text-xl fade-up">
                <b>A reciclagem de lixo eletrônico traz inúmeros benefícios para o futuro</b>. Ela <b>reduz a poluição</b>, impedindo a liberação de toxinas no meio ambiente, e <b>conserva recursos naturais</b> ao recuperar metais, o que diminui a necessidade de mineração. Além disso, <b>promove uma economia circular</b>, onde materiais são reutilizados, e <b>gera empregos no setor de reciclagem</b>. A reciclagem também <b>estimula inovações tecnológicas</b>, aumenta a <b>conscientização ambiental</b> e <b>contribui para os Objetivos de Desenvolvimento Sustentável (ODS) da ONU</b>, ajudando a reduzir a quantidade de lixo em aterros. <b>Esses fatores juntos promovem um futuro mais sustentável e responsável</b>.
            </p>
        </div>
        <div class="container mx-auto fade-section px-4">
            <div class=" mb-10  p-5 md:p-10 gap-10 md:gap-15 bg-third rounded-2xl flex flex-col justify-center items-center text-center">
                <p class="text-lg md:text-xl lg:text-2xl font-bold fade-section is-visible text-white">
                    Encontre o <span class="text-primary font-dm-serif-display italic">ponto de coleta</span> mais próximo e faça sua parte para um planeta mais verde!
                </p>
                <a href="<?= BASE_URL?>/pontos-coleta" class="group p-4 md:p-5 bg-[#49776b] w-full text-sm md:text-lg rounded-2xl justify-between items-center flex gap-2 font-bold text-white
                hover:bg-fourth hover:text-black transition-all">
                    Ver no mapa
                    <i class="fa-solid fa-arrow-right text-2xl group-hover:-rotate-45deg transition-all rounded-full"></i> 
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const modelViewer = document.getElementById('bota-3d');
    
    // Altura total do scroll que você quer usar para a animação
    // Ex: 3000 pixels (isso deve ser ajustado ao tamanho do seu conteúdo)
    const scrollHeightToAnimate = 5000; 
    
    // Rotação total desejada (ex: girar 360 graus)
    const rotationTotal = 360; 

    // Ouve o evento de scroll
    window.addEventListener('scroll', () => {
        
        // 1. Obter a Posição Atual do Scroll
        // (Verifique window.scrollY ou document.documentElement.scrollTop para compatibilidade)
        const scrollY = window.scrollY;

        // 2. Calcular o Progresso da Animação (de 0 a 1)
        // O scroll progress indica o quão longe o usuário rolou dentro do range
        const scrollProgress = Math.min(1, scrollY / scrollHeightToAnimate);

        // 3. Calcular a Nova Rotação (em graus)
        // Ex: Se o progresso for 0.5, a rotação será 180 graus (360 * 0.5)
        const newRotation = rotationTotal * scrollProgress;

        // 4. Aplicar a Nova Rotação ao modelo 3D
        // A sintaxe de camera-orbit é "azimuth inclination distance"
        // Estamos mudando apenas o azimuth (rotação horizontal)
        const newOrbit = `${newRotation}deg 80deg`;

        modelViewer.setAttribute('camera-orbit', newOrbit);

        // Opcional: Para fazer a bota "subir" ou "descer" com o scroll (movimento vertical)
        // Você também pode manipular os atributos CSS (top, transform)
    });
});
</script>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>