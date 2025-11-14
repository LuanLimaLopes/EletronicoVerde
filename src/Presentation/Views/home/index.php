<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    .leaflet-popup-content {
        margin: 10px;
        max-width: 300px;
    }
    .leaflet-popup-content h3 {
        color: #04A777;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .user-marker {
        background-color: #4285F4;
        border: 3px solid white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }
</style>

<!-- HERO SECTION -->
<header class="relative z-5">
    <div class="h-[100vh] w-full text-white relative">
      <img src="<?= ASSETS_URL ?>/images/e-waste2.png" alt="Lixo Eletrônico"
        class="absolute top-0 left-0 w-full h-[100vh] object-cover brightness-30 z-1" />
      
      <div class="container mx-auto py-4 flex flex-col h-[100vh] gap-10 justify-center z-20 relative fade-left">
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
    <section class="relative py-4 flex flex-col justify-center h-fit z-[10] bg-cinza ">
      <div class="mx-auto container flex flex-col justify-between items-center bg-[#1c3931] p-10 gap-20 h-fit rounded-3xl zoom-in">
        <div class="flex lg:flex-row gap-10 md:flex-col ">
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
      <h2 class="mx-auto text-4xl text-whitey font-bold fade-section">
          Descarte eletrônico em <span class="text-primary italic font-dm-serif-display">números</span>
      </h2>

      <div class="grid lg:grid-cols-4 lg:grid-rows-2 lg:gap-4 mx-auto container h-full sm:grid-cols-2 sm:grid-rows-3 sm:gap-4">
        
        <div class="rounded-3xl bg-emerald-950 p-5 gap-10 text-white text-center flex items-center justify-center flex-col lg:row-span-2 sm:row-span-2 fade-left">
          <h2 class="text-5xl font-bold text-primary font-dm-serif-display">62 milhões</h2>
          <p class="text-xl">Toneladas de lixo eletrônico foram geradas no mundo em 2022</p>
        </div>
        
        <div class="rounded-3xl bg-emerald-900 p-5 gap-5 text-white text-center flex items-center justify-center flex-col lg:col-span-2 sm:col-span-1 fade-bottom">
          <h2 class="text-5xl font-bold text-amarelo font-dm-serif-display">5º</h2>
          <p class="text-xl">O Brasil é o 5º maior produtor de lixo eletrônico do mundo, gerando cerca de 2,4 milhões de toneladas por ano.</p>
        </div>
        
        <div class="rounded-3xl bg-emerald-200 p-5 gap-5 text-white text-center flex items-center justify-center flex-col fade-diag-bottom-left">
          <h2 class="text-5xl font-bold text-emerald-700 font-dm-serif-display">22,3%</h2>
          <p class="text-xl text-black">Do lixo eletrônico global foi reciclado corretamente em 2022</p>
        </div>
        
        <div class="rounded-3xl bg-amarelo p-5 gap-5 text-white text-center flex items-center justify-center flex-col fade-up">
          <h2 class="text-5xl font-bold text-emerald-900 font-dm-serif-display">87%</h2>
          <p class="text-xl text-black">Dos brasileiros afirmam guardar aparelhos eletrônicos sem uso em casa</p>
        </div>

        <div class="rounded-3xl bg-emerald-600 p-5 gap-5 relative text-white text-center flex items-center justify-center flex-col lg:col-span-2 md:col-span-1 fade-right">
          <div class="flex flex-col gap-5 ">
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
        <h1 class="text-4xl font-bold text-black text-center fade-section">
            Contribua para a <span class="text-primary font-dm-serif-display italic">sustentabilidade</span>
        </h1>  

        <!-- Card 1 -->
        <div class="sust-1 z-1 sticky h-[20rem] text-cinza-txt border-t-3 border-primary p-5 mb-[20rem] font-black fade-section">
            <div class="z-[-2] w-full h-full bg-whitey absolute top-0 left-0 shadow-[inset_0px_0px_15px_#ededed]"></div>
            <div class="flex flex-row justify-between items-center">
              <span class="z-5 text-3xl flex flex-row gap-5 py-5 text-primary fade-up">
                  <i class="fa-solid fa-handshake-simple text-primary"></i> Contribuição Social
              </span>
              <span class="text-3xl text-primary">(01)</span>
            </div>
            <div class="flex flex-col justify-between gap-10 fade-up">
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
              <span class="z-[5] text-3xl flex flex-row gap-5 py-5 text-second fade-up">
                  <i class="fa-solid fa-brain text-second"></i> Conscientização
              </span>
              <span class="text-3xl text-second">(02)</span>
            </div>
            <div class="flex flex-col justify-between gap-10 fade-up">
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
              <span class="z-[5] text-3xl flex flex-row gap-5 py-5 text-third fade-up">
                  <i class="fa-solid fa-hand-pointer text-third"></i> Facilidade de Uso
              </span>
              <span class="text-3xl text-third fade-up">(03)</span>
            </div>
            <div class="flex flex-col justify-between gap-10 fade-up">
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
    <section id="pontos" class="flex flex-col gap-15 bg-whitey relative pb-10 min-h-[100vh] rounded-b-[30px]">
      <h1 class="text-4xl font-bold text-black text-center fade-section">
          Encontre o <span class="text-primary font-dm-serif-display italic">ponto de coleta</span> mais próximo de você
      </h1>

      <div class="mx-auto container gap-5 flex flex-col h-full fade-section">
          <div class="h-fit flex flex-row gap-5">
              <input type="text" name="search" id="search" placeholder="Escreva aqui o endereço ou CEP" 
                     class="text-xl border-primary border-2 bg-white p-4 font-bold rounded-lg w-full"
                     maxlength="9"> 
              <button type="button" onclick="buscarPorCep()" id="btnBuscar"
                      class="bg-primary text-white text-lg px-8 rounded-lg cursor-pointer font-bold hover:bg-second transition-all">
                  Pesquisar
              </button>
          </div>

          <!-- Mensagens -->
          <div id="mensagem" class="hidden p-4 rounded-lg"></div>

          <!-- MAPA -->
          <div class="w-full h-[60vh] relative rounded-3xl overflow-hidden border-2 border-gray-200">
              <div id="map" style="width: 100%; height: 100%;"></div>
          </div>

          <!-- Lista de Pontos Encontrados -->
          <div id="resultados" class="hidden mt-5">
              <h2 class="text-2xl font-bold mb-4">Pontos Encontrados:</h2>
              <div id="lista-pontos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                  <!-- Será preenchido via JavaScript -->
              </div>
          </div>

          <div>
              <a href="/eletronicoverde/materiais-aceitos" class="group p-5 bg-fourth w-fit rounded-3xl justify-center items-center flex gap-2 font-bold text-cinza-txt hover:bg-primary hover:text-white transition-all">
                  Saiba quais são os <span class="text-primary group-hover:text-white transition-all">materiais aceitos</span>
                  <i class="fa-solid fa-arrow-right text-2xl group-hover:rotate-[-45deg] transition-all rounded-full"></i> 
              </a>
          </div>
        </div>
    </section>
</main>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let map;
let markers = [];
let userMarker;

// Inicializa o mapa
function initMap() {
    // Posição inicial (Campinas)
    map = L.map('map').setView([-22.9068, -47.0632], 12);
    
    // Adiciona camada do OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Carrega todos os pontos inicialmente
    carregarTodosPontos();
}

// Busca CEP e converte para coordenadas
async function buscarPorCep() {
    const cep = document.getElementById('search').value.replace(/\D/g, '');
    const btnBuscar = document.getElementById('btnBuscar');
    
    if (cep.length !== 8) {
        mostrarMensagem('Por favor, insira um CEP válido com 8 dígitos', 'erro');
        return;
    }
    
    btnBuscar.disabled = true;
    btnBuscar.textContent = 'Buscando...';
    mostrarMensagem('Buscando localização...', 'info');
    
    try {
        // Busca CEP via ViaCEP
        const cepResponse = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const cepData = await cepResponse.json();
        
        if (cepData.erro) {
            mostrarMensagem('CEP não encontrado', 'erro');
            btnBuscar.disabled = false;
            btnBuscar.textContent = 'Pesquisar';
            return;
        }
        
        // Monta endereço completo
        const endereco = `${cepData.logradouro}, ${cepData.bairro}, ${cepData.localidade}, ${cepData.uf}, Brasil`;
        
        // Geocodifica usando Nominatim
        const geoResponse = await fetch(
            `https://nominatim.openstreetmap.org/search?` + 
            `q=${encodeURIComponent(endereco)}` +
            `&format=json&limit=1`,
            {
                headers: {
                    'User-Agent': 'EletronicoVerde/1.0'
                }
            }
        );
        
        const geoData = await geoResponse.json();
        
        if (geoData && geoData.length > 0) {
            const lat = parseFloat(geoData[0].lat);
            const lng = parseFloat(geoData[0].lon);
            
            buscarPontosProximos(lat, lng);
        } else {
            mostrarMensagem('Não foi possível localizar o endereço', 'erro');
        }
        
    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        mostrarMensagem('Erro ao buscar CEP. Tente novamente.', 'erro');
    } finally {
        btnBuscar.disabled = false;
        btnBuscar.textContent = 'Pesquisar';
    }
}

// Busca pontos próximos via API
async function buscarPontosProximos(lat, lng) {
    try {
        const response = await fetch(`/eletronicoverde/api/pontos/buscar-proximos?lat=${lat}&lng=${lng}&raio=10`);
        const data = await response.json();
        
        if (data.sucesso && data.dados.length > 0) {
            limparMarcadores();
            adicionarMarcadorUsuario(lat, lng);
            
            data.dados.forEach(ponto => {
                adicionarMarcadorPonto(ponto);
            });
            
            map.setView([lat, lng], 13);
            exibirListaPontos(data.dados);
            mostrarMensagem(`${data.dados.length} ponto(s) encontrado(s) próximo a você!`, 'sucesso');
        } else {
            mostrarMensagem('Nenhum ponto de coleta encontrado próximo a você. Mostrando todos os pontos disponíveis.', 'aviso');
            carregarTodosPontos();
        }
        
    } catch (error) {
        console.error('Erro:', error);
        mostrarMensagem('Erro ao buscar pontos de coleta. Tente novamente.', 'erro');
    }
}

// Carrega todos os pontos no mapa
async function carregarTodosPontos() {
    try {
        const response = await fetch('/eletronicoverde/api/pontos/listar-todos');
        const data = await response.json();
        
        if (data.sucesso && data.dados.length > 0) {
            data.dados.forEach(ponto => {
                if (ponto.latitude && ponto.longitude) {
                    adicionarMarcadorPonto(ponto);
                }
            });
        }
    } catch (error) {
        console.error('Erro ao carregar pontos:', error);
    }
}

// Adiciona marcador do usuário
function adicionarMarcadorUsuario(lat, lng) {
    if (userMarker) {
        map.removeLayer(userMarker);
    }
    
    const userIcon = L.divIcon({
        className: 'user-marker',
        iconSize: [20, 20],
        iconAnchor: [10, 10],
    });
    
    userMarker = L.marker([lat, lng], { icon: userIcon })
        .addTo(map)
        .bindPopup('<div style="text-align: center; font-weight: bold;">📍 Sua localização</div>');
}

// Adiciona marcador de ponto de coleta
function adicionarMarcadorPonto(ponto) {
    const pontoIcon = L.icon({
        iconUrl: 'data:image/svg+xml;base64,' + btoa(`
            <svg width="32" height="40" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0C7.2 0 0 7.2 0 16c0 12 16 24 16 24s16-12 16-24c0-8.8-7.2-16-16-16z" fill="#04A777"/>
                <circle cx="16" cy="16" r="8" fill="white"/>
            </svg>
        `),
        iconSize: [32, 40],
        iconAnchor: [16, 40],
        popupAnchor: [0, -40]
    });
    
    const marker = L.marker([ponto.latitude, ponto.longitude], { icon: pontoIcon })
        .addTo(map);
    
    const popupContent = `
        <div style="max-width: 300px;">
            <h3 style="color: #04A777; font-weight: bold; margin-bottom: 8px;">${ponto.empresa}</h3>
            ${ponto.distancia ? `<p style="color: #666; font-size: 14px; margin-bottom: 5px;"><strong>📍 Distância:</strong> ${ponto.distancia} km</p>` : ''}
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;"><strong>📍</strong> ${ponto.endereco}, ${ponto.numero}</p>
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;"><strong>📞</strong> ${ponto.telefone}</p>
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;"><strong>✉️</strong> ${ponto.email}</p>
            <p style="color: #666; font-size: 14px; margin-bottom: 8px;"><strong>🕒</strong> ${ponto.hora_inicio} - ${ponto.hora_encerrar}</p>
            ${ponto.materiais && ponto.materiais.length > 0 ? `
                <div style="margin-top: 8px;">
                    <p style="font-weight: bold; color: #333; font-size: 13px; margin-bottom: 5px;">Materiais aceitos:</p>
                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                        ${ponto.materiais.map(m => `<span style="background: #D3FFF2; color: #04A777; padding: 2px 8px; border-radius: 4px; font-size: 11px;">${m.nome}</span>`).join('')}
                    </div>
                </div>
            ` : ''}
        </div>
    `;
    
    marker.bindPopup(popupContent);
    markers.push(marker);
}

// Limpa marcadores do mapa
function limparMarcadores() {
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
}

// Exibe lista de pontos
function exibirListaPontos(pontos) {
    const resultadosDiv = document.getElementById('resultados');
    const listaPontos = document.getElementById('lista-pontos');
    
    listaPontos.innerHTML = '';
    
    pontos.forEach((ponto, index) => {
        const card = `
            <div class="bg-white border-2 border-primary rounded-lg p-4 hover:shadow-lg transition-all cursor-pointer" onclick="focusPonto(${index})">
                <h3 class="text-xl font-bold text-primary mb-2">${ponto.empresa}</h3>
                ${ponto.distancia ? `<p class="text-sm text-gray-600 mb-2">📍 <strong>${ponto.distancia} km</strong> de distância</p>` : ''}
                <p class="text-gray-700"><i class="fa-solid fa-location-dot"></i> ${ponto.endereco}, ${ponto.numero}</p>
                <p class="text-gray-700"><i class="fa-solid fa-phone"></i> ${ponto.telefone}</p>
                <p class="text-gray-700"><i class="fa-solid fa-envelope"></i> ${ponto.email}</p>
                <p class="text-gray-700"><i class="fa-solid fa-clock"></i> ${ponto.hora_inicio} - ${ponto.hora_encerrar}</p>
                ${ponto.materiais && ponto.materiais.length > 0 ? `
                    <div class="mt-2">
                        <p class="font-bold text-sm">Materiais aceitos:</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            ${ponto.materiais.map(m => `<span class="bg-fourth text-primary text-xs px-2 py-1 rounded">${m.nome}</span>`).join('')}
                        </div>
                    </div>
                ` : ''}
            </div>
        `;
        listaPontos.innerHTML += card;
    });
    
    resultadosDiv.classList.remove('hidden');
}

// Foca no marcador quando clicar no card
function focusPonto(index) {
    if (markers[index]) {
        map.setView(markers[index].getLatLng(), 15);
        markers[index].openPopup();
    }
}

// Mostra mensagem
function mostrarMensagem(texto, tipo) {
    const mensagemDiv = document.getElementById('mensagem');
    mensagemDiv.className = 'p-4 rounded-lg ';
    
    if (tipo === 'sucesso') {
        mensagemDiv.className += 'bg-green-100 border border-green-400 text-green-700';
    } else if (tipo === 'erro') {
        mensagemDiv.className += 'bg-red-100 border border-red-400 text-red-700';
    } else if (tipo === 'aviso') {
        mensagemDiv.className += 'bg-yellow-100 border border-yellow-400 text-yellow-700';
    } else {
        mensagemDiv.className += 'bg-blue-100 border border-blue-400 text-blue-700';
    }
    
    mensagemDiv.textContent = texto;
    mensagemDiv.classList.remove('hidden');
    
    setTimeout(() => {
        mensagemDiv.classList.add('hidden');
    }, 5000);
}

// Permite buscar com Enter
document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        buscarPorCep();
    }
});

// Formata CEP enquanto digita
document.getElementById('search').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 5) {
        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
    }
    e.target.value = value;
});

// Inicializa o mapa quando a página carregar
window.addEventListener('load', initMap);
</script>