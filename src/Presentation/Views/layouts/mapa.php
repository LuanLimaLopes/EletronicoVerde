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

    #map-overlay {
        transition: opacity .3s ease;
    }

    #map-overlay.hidden {
        opacity: 0;
        pointer-events: none;
    }
</style>

<main class="relative z-2 bg-whitey rounded-b-[30px]">
    <section id="pontos" class="container flex flex-col gap-15 mx-auto relative pt-30 pb-30 min-h-screen px-5 md:px-0">
        <h1 class="text-4xl font-bold text-black text-center fade-section">
            Encontre o <span class="text-primary font-dm-serif-display italic">ponto de coleta</span> mais próximo de você
        </h1>

        <div class="mx-auto container gap-5 flex flex-col h-full fade-section">
            <!-- Barra de Busca -->
            <div class="h-fit flex flex-col md:flex-row gap-5">
                <input type="text" 
                       name="search" 
                       id="search" 
                       placeholder="Digite seu CEP (ex: 13087-280)" 
                       class="text-md md:text-xl border-primary border-3 bg-white p-4 font-bold text-cinza-txt rounded-xl w-full hover:bg-fourth transition ease-out focus:outline-0 focus:shadow-[0px_0px_0px_5px_#04A77750]"
                       maxlength="9"> 
                <button type="button" 
                        onclick="buscarPorCep()" 
                        id="btnBuscar"
                        class="bg-primary text-white text-lg py-3 px-8 rounded-xl cursor-pointer font-bold hover:bg-second transition-all focus:outline-0 ">
                    Pesquisar
                </button>
            </div>

            <!-- Mensagens -->
            <div id="mensagem" class="hidden p-4 rounded-lg"></div>

            <!-- MAPA -->
            <div class="w-full h-[60vh] relative rounded-3xl overflow-hidden border-2 border-gray-200">
    
                <!-- Overlay que bloqueia interação no mobile -->
                <div id="map-overlay"
                    class="absolute inset-0 bg-transparent z-[500] flex items-center justify-center md:hidden">
                    <span class="bg-black bg-opacity-60 text-white text-sm px-4 py-2 rounded-full backdrop-blur-md">
                        Toque para interagir com o mapa
                    </span>
                </div>

                <div id="map" style="width: 100%; height: 100%;"></div>
            </div>


            <!-- Lista de Pontos Encontrados -->
            <div id="resultados" class="hidden mt-5">
                <h2 class="text-2xl font-bold mb-4">Pontos Próximos a Você:</h2>
                <div id="lista-pontos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Será preenchido via JavaScript -->
                </div>
            </div>

            <div>
                <a href="/eletronicoverde/materiais-aceitos" class="group p-5 bg-fourth w-full md:w-fit rounded-3xl justify-between md:justify-center items-center flex flex-row md:gap-2 font-bold text-cinza-txt hover:bg-primary hover:text-white transition-all">
                <p>Saiba quais são os <span class="text-primary group-hover:text-white transition-all">materiais aceitos</span> </p></span>
                    <i class="fa-solid fa-arrow-right text-2xl group-hover:-rotate-45 transition-all rounded-full"></i>
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
        // 1. Busca CEP via ViaCEP (API brasileira gratuita)
        const cepResponse = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const cepData = await cepResponse.json();
        
        if (cepData.erro) {
            mostrarMensagem('CEP não encontrado', 'erro');
            btnBuscar.disabled = false;
            btnBuscar.textContent = 'Pesquisar';
            return;
        }
        
        // 2. Monta endereço completo
        const endereco = `${cepData.logradouro}, ${cepData.bairro}, ${cepData.localidade}, ${cepData.uf}, Brasil`;
        
        // 3. Geocodifica usando Nominatim (OpenStreetMap - gratuito)
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
            // Remove marcadores antigos
            limparMarcadores();
            
            // Adiciona marcador do usuário
            adicionarMarcadorUsuario(lat, lng);
            
            // Adiciona marcadores dos pontos
            data.dados.forEach(ponto => {
                adicionarMarcadorPonto(ponto);
            });
            
            // Centraliza mapa na localização do usuário
            map.setView([lat, lng], 13);
            
            // Exibe lista de pontos
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

// Carrega todos os pontos no mapa (inicial)
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
        .bindPopup('<div style="text-align: center; font-weight: bold;"><i class="fa-solid fa-location-dot text-primary"></i> Sua localização</div>');
}

// Adiciona marcador de ponto de coleta
function adicionarMarcadorPonto(ponto) {
    // Ícone customizado para pontos de coleta
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
    
    // Conteúdo do popup
    const popupContent = `
        <div style="max-width: 300px;">
            <h3 style="color: #04A777; font-weight: bold; margin-bottom: 8px;">${ponto.empresa}</h3>
            ${ponto.distancia ? `<p style="color: #666; font-size: 14px; margin-bottom: 5px;"><strong><i class="fa-solid fa-location-pin text-second"></i> Distância:</strong> ${ponto.distancia} km</p>` : ''}
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;"><strong><i class="fa-solid fa-location-dot text-second"></i></strong> ${ponto.endereco}, ${ponto.numero}</p>
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;"><strong><i class="fa-solid fa-phone text-second"></i></strong> ${ponto.telefone}</p>
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;"><strong><i class="fa-solid fa-envelope text-second"></i></strong> ${ponto.email}</p>
            <p style="color: #666; font-size: 14px; margin-bottom: 8px;"><strong><i class="fa-solid fa-clock text-second"></i></strong> ${ponto.hora_inicio} - ${ponto.hora_encerrar}</p>
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
            <div class="bg-white border-2 border-primary rounded-3xl p-4 hover:shadow-[0px_0px_0px_4px_#04A77750] transition-all duration-300 cursor-pointer" onclick="focusPonto(${index})">
                <h3 class="text-xl font-bold text-primary mb-2">${ponto.empresa}</h3>
                ${ponto.distancia ? `<p class="text-sm text-gray-600 mb-2"><i class="fa-solid fa-location-pin text-second"></i> <strong>${ponto.distancia} km</strong> de distância</p>` : ''}
                <p class="text-gray-700"><i class="fa-solid fa-location-dot text-second"></i> ${ponto.endereco}, ${ponto.numero}</p>
                <p class="text-gray-700"><i class="fa-solid fa-phone text-second"></i> ${ponto.telefone}</p>
                <p class="text-gray-700"><i class="fa-solid fa-envelope text-second"></i> ${ponto.email}</p>
                <p class="text-gray-700"><i class="fa-solid fa-clock text-second"></i> ${ponto.hora_inicio} - ${ponto.hora_encerrar}</p>
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


// --- BLOQUEIO DE INTERAÇÃO DO MAPA NO MOBILE ---

const overlay = document.getElementById('map-overlay');

// Ao tocar no overlay, ele desaparece e o mapa fica interativo
overlay.addEventListener('touchstart', () => {
    overlay.classList.add('hidden');
});

// Quando o usuário rolar a página, o overlay volta
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        // Não reativa enquanto a pessoa está tocando dentro do mapa
        if (!overlay.classList.contains('hidden')) return;

        // Reativa o bloqueio
        overlay.classList.remove('hidden');
    }
});

</script>