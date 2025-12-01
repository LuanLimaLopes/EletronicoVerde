<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    .leaflet-popup-content {
        margin: 10px;
        max-width: 300px;
        font-family: 'Inter', sans-serif;
    }

    .leaflet-popup-content p{
        display: flex;
        gap: 0.5rem;
        
    }

    .leaflet-popup-content h3 {
        color: #04A777;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .leaflet-popup-content-wrapper, .leaflet-popup-tip{
        background-color: #f9f9f980;
        backdrop-filter: blur(20px);
        border: 1px solid #ffffff8c;
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

    .leaflet-control-zoom-in, .leaflet-control-zoom-out{

        background-color: var(--color-second) !important;
        color: #fff !important;
        border-radius: 10px !important;
        width: 40px !important;
        display: flex !important;
        height: 40px !important;
        justify-content: center !important;
        align-items: center !important;
    }
    
    .leaflet-control-zoom-in:hover, .leaflet-control-zoom-out:hover{
        background-color: #037a5e !important;
    }

    .leaflet-control-zoom{
        border: none !important;
    }
</style>

<section class="relative z-2 bg-whitey rounded-b-[30px]">
    <div id="pontos" class="container mx-auto flex flex-col gap-15 relative pt-30 pb-30 min-h-screen px-4">
        <h1 class="text-4xl font-bold text-black text-center fade-section">
            Encontre o <span class="text-primary font-dm-serif-display italic">ponto de coleta</span> mais próximo de você
        </h1>

        

        <div class="mx-auto container flex flex-col h-full fade-section">

        <!-- Mensagens -->
            <div id="mensagem" class="hidden p-4 rounded-lg"></div>

            <!-- Barra de Busca -->
            <div class="h-fit flex flex-col md:flex-row">
                <input type="text" 
                       name="search" 
                       id="search" 
                       placeholder="Digite seu CEP (ex: 13075-490)" 
                       class="text-md md:text-xl border-second border-2 border-b-0 bg-white px-4 py-3 md:px-4 shadow-xs font-bold text-cinza-txt rounded-t-2xl md:rounded-tl-2xl md:rounded-tr-none w-full hover:bg-fourth transition ease-out focus:outline-0 focus:bg-fourth"
                       maxlength="9">
                <button id="btn-limpar-busca" 
                        class="bg-third hover:bg-third/70 text-white text-lg py-3 px-10 rounded-none border-second border-2 border-b-0 cursor-pointer font-bold transition-all focus:outline-0 hidden">
                    Limpar
                </button>
                <button type="button" 
                        onclick="buscarPorCep()" 
                        id="btnBuscar"
                        class="bg-second text-white text-lg py-3 px-10 rounded-none md:rounded-tr-2xl border-second border-2 border-b-0 cursor-pointer font-bold hover:bg-third transition-all focus:outline-0 ">
                    Pesquisar
                </button>
                
            </div>

            <!-- MAPA -->
            <div class="w-full h-[60vh] relative rounded-b-2xl overflow-hidden border-2 border-second">
    
                <!-- Overlay que bloqueia interação no mobile -->
                <div id="map-overlay"
                    class="absolute inset-0 bg-transparent z-[500] flex items-center justify-center cursor-pointer">
                    <span class="bg-black bg-opacity-50 text-white text-sm px-4 py-2 rounded-full backdrop-blur-md">
                        Clique ou toque para interagir com o mapa
                    </span>
                </div>


                <div id="map" style="width: 100%; height: 100%;"></div>
            </div>


            <!-- Lista de Pontos Encontrados -->
            <div id="resultados" class="hidden mt-5">
                <h2 class="text-2xl font-bold mb-4">Pontos Próximos a Você:</h2>
                <div id="lista-pontos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    </div>
                <div id="paginacao-container" class="hidden"></div>
            </div>

            <div class="mt-5">
                <a href="/eletronicoverde/materiais-aceitos" class="group p-5 bg-fourth w-full md:w-fit rounded-3xl justify-between md:justify-center items-center flex flex-row md:gap-2 font-bold text-cinza-txt hover:bg-primary hover:text-white transition-all">
                <p>Saiba quais são os <span class="text-primary group-hover:text-white transition-all">materiais aceitos</span> </p></span>
                    <i class="fa-solid fa-arrow-right text-2xl group-hover:-rotate-45 transition-all rounded-full"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// ATENÇÃO: Declaração ÚNICA de Variáveis Globais
let map;
let markers = [];
let userMarker;
let todosPontosEncontrados = []; // Armazena todos os pontos retornados pela API
let paginaAtual = 1;
const itensPorPagina = 3;

async function limparBuscaCep() {

    // 1. Limpa marcadores do mapa
    limparMarcadores();

    // 2. Esconde botão de limpar
    document.getElementById('btn-limpar-busca').classList.add('hidden');

    // 3. Limpa o input de CEP
    document.getElementById('search').value = "";

    // 4. Oculta a lista de resultados
    document.getElementById('resultados').classList.add('hidden');
    document.getElementById('lista-pontos').innerHTML = "";
    document.getElementById('paginacao-container').classList.add('hidden');

    // 5. Remove o marcador do usuário, se existir
    if (userMarker) {
        map.removeLayer(userMarker);
        userMarker = null;
    }

    // 6. Carrega novamente TODOS os pontos
    await carregarTodosPontos();

    // 7. Centraliza o mapa novamente na posição inicial
    map.setView([-22.9068, -47.0632], 12); // Campinas
    
    // 8. Reseta paginação
    paginaAtual = 1;

    mostrarMensagem("Busca limpa! Exibindo todos os pontos novamente.", "sucesso");
}

document.getElementById("btn-limpar-busca")
        .addEventListener("click", limparBuscaCep);


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

    // CORREÇÃO: Força o Leaflet a renderizar corretamente
    map.invalidateSize(); 
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
        console.log('🔍 Buscando CEP:', cep);
        
        // 🔥 AGORA USA SEU PRÓPRIO BACKEND
        const response = await fetch(`/eletronicoverde/api/geocoding/buscar-cep?cep=${cep}`);
        const data = await response.json();
        
        console.log('📦 Dados recebidos:', data);
        
        if (data.sucesso) {
            const lat = data.latitude;
            const lng = data.longitude;
            
            console.log('✅ Coordenadas:', lat, lng);
            
            // 🎯 ADICIONA O MARCADOR DO USUÁRIO NO MAPA
            adicionarMarcadorUsuario(lat, lng);
            
            // 🎯 CENTRALIZA O MAPA NA LOCALIZAÇÃO
            map.setView([lat, lng], 15);
            
            // 🎯 BUSCA PONTOS PRÓXIMOS
            await buscarPontosProximos(lat, lng);
            
        } else {
            console.error('❌ Erro:', data.mensagem);
            mostrarMensagem(data.mensagem, 'erro');
        }
        
    } catch (error) {
        console.error('💥 Erro fatal:', error);
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
        
        // Remove marcadores antigos
        limparMarcadores();

        if (data.sucesso && data.dados.length > 0) {
            
            // Adiciona marcador do usuário
            adicionarMarcadorUsuario(lat, lng);
            
            // Adiciona marcadores dos pontos
            data.dados.forEach(ponto => {
                adicionarMarcadorPonto(ponto);
            });
            
            // Centraliza mapa na localização do usuário
            map.setView([lat, lng], 13);
            map.invalidateSize(); // CORREÇÃO: Força o redimensionamento após mover e adicionar marcadores
            
            // Armazena todos os pontos e exibe a PRIMEIRA página
            todosPontosEncontrados = data.dados; 
            paginaAtual = 1;
            exibirListaPontos(todosPontosEncontrados);
            document.getElementById('btn-limpar-busca').classList.remove('hidden');
            
            async function limparBuscaCep() {

}

document.getElementById("btn-limpar-busca")
        .addEventListener("click", limparBuscaCep);

            
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
            // Opcional: Armazenar todos os pontos iniciais, caso queira mostrar a lista no carregamento.
            // todosPontosEncontrados = data.dados;
            // exibirListaPontos(todosPontosEncontrados);
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
                <path d="M16 0C7.2 0 0 7.2 0 16c0 12 16 24 16 24s16-12 16-24c0-8.8-7.2-16-16-16z" fill="#337357"/>
                <circle cx="16" cy="16" r="8" fill="#D3FFF2"/>
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
            ${ponto.distancia ? `<p style="color: #000; font-size:  clamp(10px, 12px, 14px); margin-bottom: 5px;"><i class="fa-solid fa-location-pin mr-1 text-second"></i> Distância: ${ponto.distancia} km</p>` : ''}
            <p style="color: #000; font-size:  clamp(10px, 12px, 14px); margin-bottom: 5px;"><i class="fa-solid fa-location-dot mr-1 text-second"></i> ${ponto.endereco}, ${ponto.numero}</p>
            <p style="color: #000; font-size:  clamp(10px, 12px, 14px); margin-bottom: 5px;"><i class="fa-solid fa-phone mr-1 text-second"></i> ${formatarTelefone(ponto.telefone)}</p>
            <p style="color: #000; font-size:  clamp(10px, 12px, 14px); margin-bottom: 5px;"><i class="fa-solid fa-envelope mr-1 text-second"></i> ${ponto.email}</p>
            <p style="color: #000; font-size:  clamp(10px, 12px, 14px); margin-bottom: 8px;"><i class="fa-solid fa-clock mr-1 text-second"></i> ${ponto.hora_inicio} - ${ponto.hora_encerrar}</p>
            ${ponto.materiais && ponto.materiais.length > 0 ? `
                <div style="margin-top: 8px;">
                    <p style="font-weight: bold; color: #333; font-size: 13px; margin-bottom: 5px;">Materiais aceitos:</p>
                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                        ${ponto.materiais.map(m => `<span style="background: #D3FFF2; color: #04A777; padding: 2px 8px; border-radius: 4px; font-size: 11px;">${m.nome}</span>`).join('')}
                    </div>
                </div>
            ` : ''}

            <a href="https://www.google.com/maps?q=${ponto.latitude},${ponto.longitude}" 
            target="_blank" 
            style="
                    display: inline-block;
                    background: #04A777;
                    color: white;
                    padding: 8px 12px;
                    border-radius: 6px;
                    text-decoration: none;
                    font-weight: bold;
                    text-align: center;
                    width: 100%;               
                    font-size: clamp(10px, 12px, 14px); 
                    margin-top: 10px;
            ">
            Abrir no Google Maps
            </a>

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

// Exibe lista de pontos (agora controla a paginação)
function exibirListaPontos(pontosCompletos) {
    const resultadosDiv = document.getElementById('resultados');
    const listaPontos = document.getElementById('lista-pontos');
    
    listaPontos.innerHTML = '';
    
    // LÓGICA DE PAGINAÇÃO JS
    const totalItens = pontosCompletos.length;
    const totalPaginas = Math.ceil(totalItens / itensPorPagina);
    
    // Calcula o início e fim da fatia
    const inicio = (paginaAtual - 1) * itensPorPagina;
    const fim = inicio + itensPorPagina;
    
    // Fatiar o array para obter os 10 itens da página
    const pontosDaPagina = pontosCompletos.slice(inicio, fim);
    
    if (pontosCompletos.length > 0) {
        // 1. Renderiza os Cards
        pontosDaPagina.forEach((ponto, index) => {
            // CORREÇÃO: O índice para o mapa é o índice no array COMPLETO
            const indexNoMapa = todosPontosEncontrados.findIndex(p => p.id === ponto.id); // Busca o índice original (assumindo que 'ponto.id' é único)
            // Se o id não for único ou não estiver disponível, use: const indexNoMapa = inicio + index;
            // No seu código anterior, o indexNoMapa = inicio + index estava correto se você garantir que o array 'markers' é populado na mesma ordem de 'todosPontosEncontrados'

            const card = `
                <div class="bg-white border-2 border-primary rounded-3xl p-4 hover:shadow-[0px_0px_0px_4px_#04A77750] transition-all duration-300 cursor-pointer" onclick="focusPonto(${indexNoMapa})">
                    <h3 class="text-xl font-bold text-primary mb-2">${ponto.empresa}</h3>
                    ${ponto.distancia ? `<p class="text-sm text-gray-600 mb-2"><i class="fa-solid fa-location-pin mr-1 text-second"></i>${ponto.distancia} km de distância</p>` : ''}
                    <p class="text-gray-700"><i class="fa-solid fa-location-dot mr-1 text-second"></i> ${ponto.endereco}, ${ponto.numero}</p>
                    <p class="text-gray-700"><i class="fa-solid fa-phone mr-1 text-second"></i> ${formatarTelefone(ponto.telefone)}</p>
                    <p class="text-gray-700"><i class="fa-solid fa-envelope mr-1 text-second"></i> ${ponto.email}</p>
                    <p class="text-gray-700"><i class="fa-solid fa-clock mr-1 text-second"></i> ${ponto.hora_inicio} - ${ponto.hora_encerrar}</p>
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

        // 2. Renderiza a Paginação
        renderizarPaginacao(totalPaginas, totalItens);
        
        resultadosDiv.classList.remove('hidden');
    } else {
        resultadosDiv.classList.add('hidden');
    }
}

// Função para mudar de página
function irParaPagina(novaPagina) {
    if (novaPagina < 1 || novaPagina > Math.ceil(todosPontosEncontrados.length / itensPorPagina)) {
        return; // Sai se a página for inválida
    }
    paginaAtual = novaPagina;
    exibirListaPontos(todosPontosEncontrados);
    
}

function renderizarPaginacao(totalPaginas, totalItens) {
    const paginacaoContainer = document.getElementById('paginacao-container');
    
    if (!paginacaoContainer || totalPaginas <= 1) {
        if (paginacaoContainer) paginacaoContainer.classList.add('hidden');
        return;
    }
    
    paginacaoContainer.classList.remove('hidden');
    
    // Renderiza a informação de itens
    let html = `
        <div class="text-sm text-gray-700 my-5">
            Página ${paginaAtual} de ${totalPaginas} | Total de ${totalItens} pontos encontrados.
        </div>
        
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
    `;

    // Botão ANTERIOR
    html += `
        <button onclick="irParaPagina(${paginaAtual - 1}) "
           class="${paginaAtual <= 1 ? 'pointer-events-none cursor-pointer opacity-50' : ''} relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    `;

    // Geração dos Botões de Página
    const maxBotoes = 5;
    let startPage = Math.max(1, paginaAtual - Math.floor(maxBotoes / 2));
    let endPage = Math.min(totalPaginas, startPage + maxBotoes - 1);

    if (endPage - startPage + 1 < maxBotoes) {
        startPage = Math.max(1, endPage - maxBotoes + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        html += `
            <button onclick="irParaPagina(${i})"
               class="${i == paginaAtual ? 'z-10 bg-primary cursor-pointer border-primary text-white font-semibold ' : 'bg-white cursor-pointer border-gray-300 text-gray-700 hover:bg-gray-50'} relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors">
                ${i}
            </button>
        `;
    }

    // Botão PRÓXIMO
    html += `
        <button onclick="irParaPagina(${paginaAtual + 1})"
           class="${paginaAtual >= totalPaginas ? 'pointer-events-none cursor-pointer opacity-50' : ''} relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </nav>
    `;
    
    paginacaoContainer.innerHTML = html;
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
    mensagemDiv.className = 'p-4 rounded-lg mb-5 ';
    
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
const mapContainer = document.getElementById('map'); 

// --- ATIVAR MAPA (DESKTOP + MOBILE) ---
function activateMap() {
    overlay.classList.add('hidden');
    map.scrollWheelZoom.enable();
    map.dragging.enable();
    map.invalidateSize(); // Adicionado aqui para garantir que o mapa fique visível ao interagir
}

// Touch (mobile)
overlay.addEventListener('touchstart', activateMap);

// Click (desktop)
overlay.addEventListener('click', activateMap);

// --- DESATIVAR QUANDO O MOUSE SAIR DO MAPA (DESKTOP) ---
mapContainer.addEventListener('mouseleave', () => {
    overlay.classList.remove('hidden');
    map.scrollWheelZoom.disable();
    map.dragging.disable();
});

// --- DESATIVAR QUANDO A PÁGINA ROLAR (MOBILE + DESKTOP) ---
window.addEventListener('scroll', () => {
    // Só recoloca o overlay se ele estiver escondido
    if (overlay.classList.contains('hidden')) {
        overlay.classList.remove('hidden');
        map.scrollWheelZoom.disable();
        map.dragging.disable();
    }
});

function formatarTelefone(numero) {
    if (!numero) return '';
    
    // Se vier exatamente "Telefone não informado"
    if (numero.trim().toLowerCase() === "telefone não informado") {
        return "Telefone não informado";
    }

    // Remove tudo que não for número
    numero = numero.replace(/\D/g, '');

    // Formato 11 dígitos -> (XX) XXXXX-XXXX
    if (numero.length === 11) {
        return numero.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    }

    // Formato 10 dígitos -> (XX) XXXX-XXXX
    if (numero.length === 10) {
        return numero.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
    }

    // Se não bater com nenhum formato, retorna como veio
    return numero;
}
</script>