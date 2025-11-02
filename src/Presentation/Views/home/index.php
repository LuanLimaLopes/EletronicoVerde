<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- HERO SECTION -->
<header class="relative z-5">
    <div class="h-[100vh] w-full text-white relative">
      <img src="<?= ASSETS_URL ?>/images/e-waste2.png" alt="Lixo Eletrônico"
        class="absolute top-0 left-0 w-full h-[100vh] object-cover brightness-30 z-1" />
      
      <div class="container mx-auto py-4 flex flex-col h-[100vh] gap-10 justify-center z-20 relative">
        <h2 class="text-4xl max-w-200 leading-12">
            Transforme seu
            <span class="text-[#02B97F] font-dm-serif-display italic font-normal">lixo eletrônico</span>
            em um futuro sustentável, 
            <span class="text-[#02B97F] font-dm-serif-display italic font-normal">recicle</span>
            hoje e faça a diferença para o planeta!
        </h2>
        <p class="text-xl">Encontre o ponto de coleta mais próximo de você.</p>
           
        <a href="#pontos" class="group flex flex-row items-center w-fit h-fit">
          <span class="text-xl bg-fourth text-black w-fit h-fit pl-5 rounded-full flex items-center gap-5 border-2 border-fourth
          group-hover:text-fourth transition-all duration-150 relative z-10 overflow-hidden
          after:bg-primary after:absolute after:w-0 after:h-full after:right-0 after:top-0 after:z-[-5] after:transition-all after:duration-450 hover:after:w-full after:rounded-full">
              Pontos de Coleta 
              <i class="fa-solid fa-arrow-right-long text-2xl bg-primary text-black p-4 w-fit h-fit rounded-full group-hover:text-fourth transition-all duration-150"></i>
          </span> 
        </a>
      </div>

      <div class="w-full h-[20vh] bg-linear-to-t from-cinza to-transparent absolute bottom-0 left-0 z-1">
        <div class="flex justify-center items-center w-full bottom-0 position absolute">
          <div class="relative flex justify-center items-center h-[10vh]">
            <div class="w-[2px] h-full bg-amarelo relative">
              <div class="absolute top-0 left-1/2 w-3 h-3 bg-amarelo rounded-full transform -translate-x-1/2 shadow-lg shadow-amarelo"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="relative z-2">
    
    <!-- Separador -->
    <div class="h-full bg-cinza pb-[10vh]">
      <div class="relative flex justify-center items-center h-[10vh]">
        <div class="w-[2px] h-full bg-amarelo relative">
          <div class="absolute bottom-0 left-1/2 w-3 h-3 bg-amarelo rounded-full transform -translate-x-1/2 shadow-lg shadow-amarelo"></div>
        </div>
      </div>
    </div>

    <!-- Seção: O que é lixo eletrônico -->
    <section class="relative py-4 flex flex-col justify-center h-fit z-[10] bg-cinza">
      <div class="mx-auto container flex flex-col justify-between items-center bg-[#1c3931] p-10 gap-20 h-fit rounded-3xl">
        <div class="flex lg:flex-row gap-10 md:flex-col">
          <h1 class="font-dm-serif-display text-7xl text-[#e4e4e4] w-fit">
              O que é 
              <span class="relative inline-block">
                <span class="relative text-amarelo italic">lixo eletrônico</span>
              </span>
              e por que devemos nos preocupar?
          </h1>
          <span class="h-full bg-amarelo w-1"></span>
          <p class="font-inter-tight text-3xl w-fit text-[#dadada] font-medium text-justify">
              Lixo eletrônico inclui celulares, computadores, eletrodomésticos e outros dispositivos descartados.
              Quando jogados de forma incorreta, esses resíduos liberam substâncias tóxicas que poluem o meio ambiente e afetam a saúde humana.
              Reciclar corretamente ajuda a reduzir esse impacto e reaproveitar materiais valiosos.
          </p>
        </div>
        <a href="<?= BASE_URL?>/reciclagem" class="group bg-[#49776b] w-full p-5 flex flex-row justify-between rounded-3xl font-bold text-md border-1 border-transparent text-white
        hover:bg-[#c0ece0] hover:text-black hover:border-second transition-all">
            Saiba mais <i class="fa-solid fa-arrow-right text-2xl group-hover:rotate-[-45deg] transition-all"></i>
        </a>
      </div>  
    </section>

    <!-- Separador -->
    <div class="h-full bg-cinza py-[10vh]">
      <div class="relative flex justify-center items-center h-[10vh]">
        <div class="w-[2px] h-full bg-amarelo relative">
          <div class="absolute top-0 left-1/2 w-3 h-3 bg-amarelo rounded-full transform -translate-x-1/2 shadow-lg shadow-amarelo"></div>
          <div class="absolute bottom-0 left-1/2 w-3 h-3 bg-amarelo rounded-full transform -translate-x-1/2 shadow-lg shadow-amarelo"></div>
        </div>
      </div>
    </div>

    <!-- Grid de Números -->
    <section class="h-[90vh] flex flex-col gap-15 bg-cinza relative z-[15]">
      <h2 class="mx-auto text-4xl text-whitey font-bold">
          Descarte eletrônico em <span class="text-primary italic font-dm-serif-display">números</span>
      </h2>

      <div class="grid lg:grid-cols-4 lg:grid-rows-2 lg:gap-4 mx-auto container h-full sm:grid-cols-2 sm:grid-rows-3 sm:gap-4">
        
        <div class="rounded-3xl bg-emerald-950 p-5 gap-10 text-white text-center flex items-center justify-center flex-col lg:row-span-2 sm:row-span-2">
          <h2 class="text-5xl font-bold text-primary font-dm-serif-display">62 milhões</h2>
          <p class="text-xl">Toneladas de lixo eletrônico foram geradas no mundo em 2022</p>
        </div>
        
        <div class="rounded-3xl bg-emerald-900 p-5 gap-5 text-white text-center flex items-center justify-center flex-col lg:col-span-2 sm:col-span-1">
          <h2 class="text-5xl font-bold text-amarelo font-dm-serif-display">5º</h2>
          <p class="text-xl">O Brasil é o 5º maior produtor de lixo eletrônico do mundo, gerando cerca de 2,4 milhões de toneladas por ano.</p>
        </div>
        
        <div class="rounded-3xl bg-emerald-200 p-5 gap-5 text-white text-center flex items-center justify-center flex-col">
          <h2 class="text-5xl font-bold text-emerald-700 font-dm-serif-display">22,3%</h2>
          <p class="text-xl text-black">Do lixo eletrônico global foi reciclado corretamente em 2022</p>
        </div>
        
        <div class="rounded-3xl bg-amarelo p-5 gap-5 text-white text-center flex items-center justify-center flex-col">
          <h2 class="text-5xl font-bold text-emerald-900 font-dm-serif-display">87%</h2>
          <p class="text-xl text-black">Dos brasileiros afirmam guardar aparelhos eletrônicos sem uso em casa</p>
        </div>

        <div class="rounded-3xl bg-emerald-600 p-5 gap-5 relative text-white text-center flex items-center justify-center flex-col lg:col-span-2 md:col-span-1">
          <div class="flex flex-col gap-5">
            <h2 class="text-5xl font-bold text-emerald-950 font-dm-serif-display">40 milhões</h2>
            <p class="text-xl text-amarelo">De toneladas de metais preciosos, como ouro, prata e cobre, são descartadas anualmente em dispositivos eletrônicos.</p>
          </div>
          <div>
            <a href="<?= BASE_URL?>/reciclagem" class="group absolute bg-[#141414] w-fit h-fit right-0 bottom-0 p-5 flex flex-row items-center justify-center gap-5 text-xl rounded-tl-3xl font-bold text-md border-1 border-transparent text-white
           hover:text-primary transition-all">
                Saiba mais <i class="fa-solid fa-arrow-right text-2xl group-hover:rotate-[-45deg] transition-all rounded-full"></i>
            </a>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Separador -->
    <div class="relative flex justify-center items-center h-[10vh] bg-whitey z-[11] mt-[5vh]">
      <div class="absolute w-full h-[20vh] bg-cinza -skew-y-3 bottom-5 left-0 z-10"></div>
      <div class="w-[2px] h-full bg-amarelo relative z-13">
        <div class="absolute top-0 left-1/2 w-3 h-3 bg-amarelo rounded-full transform -translate-x-1/2 shadow-lg shadow-amarelo z-12"></div>
      </div>
    </div>

    <!-- Sustentabilidade -->
    <section class="flex flex-col gap-15 bg-whitey relative h-fit pb-10">
      <div class="flex justify-center items-center w-full top-0 position absolute mb-[5vh]">      
        <div class="relative flex justify-center items-center h-[10vh]">
          <div class="w-[2px] h-full bg-amarelo-dark relative">
            <div class="absolute bottom-0 left-1/2 w-3 h-3 bg-amarelo-dark rounded-full transform -translate-x-1/2 shadow-md shadow-amarelo-dark"></div>
          </div>
        </div>
      </div>
      
      <div class="mx-auto container mt-[15vh] h-full relative flex flex-col gap-10">
        <h1 class="text-4xl font-bold text-black text-center">
            Contribua para a <span class="text-primary font-dm-serif-display italic">sustentabilidade</span>
        </h1>  

        <!-- Card 1 -->
        <div class="sust-1 z-1 sticky h-[20rem] text-cinza-txt border-t-3 border-primary p-5 mb-[20rem] font-black">
            <div class="z-[-2] w-full h-full bg-whitey absolute top-0 left-0 shadow-[inset_0px_0px_15px_#ededed]"></div>
            <div class="flex flex-row justify-between items-center">
              <span class="z-5 text-3xl flex flex-row gap-5 py-5 text-primary">
                  <i class="fa-solid fa-handshake-simple text-primary"></i> Contribuição Social
              </span>
              <span class="text-3xl text-primary">(01)</span>
            </div>
            <div class="flex flex-col justify-between gap-10">
              <p class="z-5 text-2xl max-w-2/3 font-bold">
                  O descarte correto de eletrônicos apoia iniciativas que reaproveitam materiais, beneficiam comunidades locais e promovem uma economia mais justa e sustentável.
              </p>
              <ol class="list-decimal list-inside flex flex-col font-medium">
                <li class="text-2xl">Geração de empregos na reciclagem</li>
                <li class="text-2xl">Doação de peças para educação e inclusão digital</li>
                <li class="text-2xl">Redução da desigualdade tecnológica</li>
              </ol>
            </div>
        </div>
  
        <!-- Card 2 -->
        <div class="sust-2 z-2 sticky h-[20rem] text-cinza-txt border-t-3 border-second p-5 mb-[14rem] font-black">
            <div class="z-[-2] w-full h-full bg-whitey absolute top-0 left-0 shadow-[inset_0px_0px_15px_#ededed]"></div>
            <div class="flex flex-row justify-between items-center">
              <span class="z-[5] text-3xl flex flex-row gap-5 py-5 text-second">
                  <i class="fa-solid fa-brain text-second"></i> Conscientização
              </span>
              <span class="text-3xl text-second">(02)</span>
            </div>
            <div class="flex flex-col justify-between gap-10">
              <p class="text-2xl z-[5] max-w-2/3 font-bold">
                  Descarte correto de eletrônicos é um passo essencial para proteger o meio ambiente, preservar recursos naturais e garantir um futuro sustentável para as próximas gerações.
              </p>
              <ol class="list-decimal list-inside flex flex-col font-medium">
                <li class="text-2xl">50 milhões de toneladas de e-lixo geradas por ano</li>
                <li class="text-2xl">Menos poluição nos solos e rios</li>
                <li class="text-2xl">Redução da extração de metais pesados</li>
              </ol>
            </div>
        </div>
  
        <!-- Card 3 -->
        <div class="z-3 sticky h-[20rem] top-[calc(20vh + 8.5em)] text-cinza-txt border-t-3 border-third p-5 mb-[7.5rem] font-black">
            <div class="z-[-2] w-full h-full bg-whitey absolute top-0 left-0 shadow-[inset_0px_0px_15px_#ededed]"></div>
            <div class="flex flex-row justify-between items-center">
              <span class="z-[5] text-3xl flex flex-row gap-5 py-5 text-third">
                  <i class="fa-solid fa-hand-pointer text-third"></i> Facilidade de Uso
              </span>
              <span class="text-3xl text-third">(03)</span>
            </div>
            <div class="flex flex-col justify-between gap-10">
              <p class="text-2xl z-[5] max-w-2/3 font-bold">
                  Encontre rapidamente o ponto de coleta mais próximo com uma interface intuitiva e fácil de navegar.
              </p>
              <ol class="list-decimal list-inside flex flex-col font-medium">
                <li class="text-2xl">Busca por CEP</li>
                <li class="text-2xl">Visualização no mapa em tempo real</li>
                <li class="text-2xl">Atualizações frequentes dos pontos</li>
              </ol>
            </div>
        </div>
      </div>
    </section>

    <!-- Separador -->
    <div class="h-full bg-whitey py-[10vh]">
      <div class="relative flex justify-center items-center h-[10vh]">
        <div class="w-[2px] h-full bg-amarelo-dark relative">
          <div class="absolute top-0 left-1/2 w-3 h-3 bg-amarelo-dark rounded-full transform -translate-x-1/2 shadow-lg shadow-amarelo-dark"></div>
          <div class="absolute bottom-0 left-1/2 w-3 h-3 bg-amarelo-dark rounded-full transform -translate-x-1/2 shadow-lg shadow-amarelo-dark"></div>
        </div>
      </div>
    </div>

    <!-- Pontos de Coleta -->
    <section id="pontos" class="flex flex-col gap-15 bg-whitey relative pb-10 min-h-[100vh]">
      <h1 class="text-4xl font-bold text-black text-center">
          Encontre o <span class="text-primary font-dm-serif-display italic">ponto de coleta</span> mais próximo de você
      </h1>

      <div class="mx-auto container gap-5 flex flex-col h-full">
        <div class="h-fit flex flex-row gap-5">
          <input type="text" name="search" id="search" placeholder="Escreva aqui o endereço ou CEP" 
                 class="text-xl border-primary border-2 bg-white p-4 font-bold rounded-lg w-full"> 
          <button type="submit" class="bg-primary text-white text-lg px-8 rounded-lg cursor-pointer font-bold">
              Pesquisar
          </button>
        </div>

        <!-- MAPA -->
        <div class="w-full h-[60vh] relative rounded-3xl">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14705.03362798809!2d-47.068513099475105!3d-22.86691079822433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c8c6732420f793%3A0x49a086172215a72a!2sUNISAL%20Campinas%20-%20Campus%20S%C3%A3o%20Jos%C3%A9!5e0!3m2!1spt-BR!2sbr!4v1749054180508!5m2!1spt-BR!2sbr" 
              width="100%" 
              height="100%" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div>
          <a href="/eletronicoverde/materiais-aceitos" class="group p-5 bg-fourth w-fit rounded-xl justify-center items-center flex gap-2 font-bold text-cinza-txt">
              Saiba quais são os <span class="text-primary">materiais aceitos</span>
              <i class="fa-solid fa-arrow-right text-2xl group-hover:rotate-[-45deg] transition-all rounded-full"></i> 
          </a>
        </div>
      </div>
    </section>
</main>