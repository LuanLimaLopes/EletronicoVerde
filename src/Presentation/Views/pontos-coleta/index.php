<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<main class="relative z-2 bg-white">
    <section id="pontos" class="container flex flex-col gap-15 mx-auto bg-white relative mt-30 pb-10 min-h-[100vh]">
        <h1 class="text-4xl font-bold text-black text-center fade-section">
            Encontre o <span class="text-primary font-dm-serif-display italic">ponto de coleta</span> mais próximo de você
        </h1>

        <div class="mx-auto container gap-5 flex flex-col h-full fade-section">
            <div class="h-fit flex flex-row gap-5">
                <input type="text" name="search" id="search" placeholder="Escreva aqui o endereço ou CEP" 
                       class="text-xl border-primary border-2 bg-white p-4 font-bold rounded-lg w-full"> 
                <button type="submit" onclick="buscarPontos()" 
                        class="bg-primary text-white text-lg px-8 rounded-lg cursor-pointer font-bold hover:bg-second transition-all">
                    Pesquisar
                </button>
            </div>

            <!-- MAPA -->
            <div class="w-full h-[60vh] relative rounded-3xl overflow-hidden">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14705.03362798809!2d-47.068513099475105!3d-22.86691079822433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94c8c6732420f793%3A0x49a086172215a72a!2sUNISAL%20Campinas%20-%20Campus%20S%C3%A3o%20Jos%C3%A9!5e0!3m2!1spt-BR!2sbr!4v1749054180508!5m2!1spt-BR!2sbr" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
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

<script>
function buscarPontos() {
    const cep = document.getElementById('search').value.replace(/\D/g, '');
    
    if (cep.length !== 8) {
        alert('Por favor, insira um CEP válido com 8 dígitos');
        return;
    }
    
    // Buscar via API
    fetch(`/api/pontos/buscar-cep?cep=${cep}`)
        .then(response => response.json())
        .then(data => {
            if (data.sucesso && data.dados.length > 0) {
                exibirResultados(data.dados);
            } else {
                alert('Nenhum ponto de coleta encontrado para este CEP.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao buscar pontos de coleta. Tente novamente.');
        });
}

function exibirResultados(pontos) {
    const resultadosDiv = document.getElementById('resultados');
    const listaPontos = document.getElementById('lista-pontos');
    
    listaPontos.innerHTML = '';
    
    pontos.forEach(ponto => {
        const card = `
            <div class="bg-white border-2 border-primary rounded-lg p-4 hover:shadow-lg transition-all">
                <h3 class="text-xl font-bold text-primary mb-2">${ponto.empresa}</h3>
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

// Permitir buscar com Enter
document.getElementById('search').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        buscarPontos();
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>