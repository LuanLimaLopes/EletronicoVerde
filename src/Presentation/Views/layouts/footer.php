<footer class="bg-primary relative w-full h-[30rem] md:h-[25rem] flex justify-center z-0">
  <div class="bg-primary fixed bottom-0 h-[30rem] md:h-[25rem] w-full justify-between p-10 flex flex-col gap-10">


    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start items-start gap-10">


      <a href="/eletronicoverde" class="group transition-all duration-150">
        <h1 class="text-base lg:text-xl font-bold flex flex-row items-center gap-3.5">
          <img src="<?= ASSETS_URL ?>/images/Logo branca.png"
               alt="Logo Eletrônico Verde"
               class="w-14 transition-all duration-150" />

          <span class="bg-white text-primary p-2 rounded-3xl rounded-tl-none border-2 border-white relative overflow-hidden z-1
                group-hover:rounded-tr-sm group-hover:rounded-tl-3xl group-hover:text-white transition-all duration-150
                before:absolute before:h-full before:-z-1 before:w-0 group-hover:before:w-full before:bg-primary before:bottom-0 before:left-0 before:transition-all before:duration-250">
            Eletrônico Verde
          </span>
        </h1>
      </a>

      <div class="flex flex-col gap-8 items-start sm:items-end">

        <ul class="flex flex-col gap-5 text-white text-lg text-start sm:text-right">
          <li>
            <a href="/eletronicoverde"
               class="relative transition-all duration-150 before:absolute before:h-[1px] before:w-0 hover:before:w-full before:bg-white before:-bottom-1 before:left-0 before:transition-all before:duration-150">
               Início
            </a>
          </li>

          <li>
            <a href="<?= BASE_URL ?>/pontos-coleta"
               class="relative transition-all duration-150 before:absolute before:h-px before:w-0 hover:before:w-full before:bg-white before:-bottom-1 before:left-0 before:transition-all before:duration-150">
               Pontos de Coleta
            </a>
          </li>

          <li>
            <a href="<?= BASE_URL ?>/materiais-aceitos"
               class="relative transition-all duration-150 before:absolute before:h-px before:w-0 hover:before:w-full before:bg-white before:-bottom-1 before:left-0 before:transition-all before:duration-150">
               Materiais Aceitos
            </a>
          </li>

          <li>
            <a href="<?= BASE_URL ?>/reciclagem"
               class="relative transition-all duration-150 before:absolute before:h-px before:w-0 hover:before:w-full before:bg-white before:-bottom-1 before:left-0 before:transition-all before:duration-150">
               Reciclagem
            </a>
          </li>
        </ul>


        <a href="<?= BASE_URL ?>/login"
           class="text-white border border-white px-4 py-2 rounded-4xl relative transition-all duration-300 overflow-hidden hover:text-primary z-1
                  before:absolute before:h-full before:-z-1 before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-300">
          Acesso restrito
        </a>

      </div>

    </div>

    <p class="text-center text-white w-full">
      © 2025 Eletrônico Verde. Todos os direitos reservados.
    </p>
  </div>
</footer>

<script>
    const effectSelectors = ['.fade-section', '.fade-left', '.zoom-in','.fade-right','.fade-in','.fade-up','.fade-bottom', '.fade-diag-bottom-left'];

    const targets = document.querySelectorAll(effectSelectors.join(','));

    const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        // obs.unobserve(entry.target); // opcional: anima só uma vez
        }
    });
    }, { threshold: 0.4 });

    targets.forEach(t => observer.observe(t));

function animateCounters() {
    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter => {
        const suffix = counter.dataset.suffix || "";
        const target = parseFloat(counter.textContent.replace(",", "."));

        if (isNaN(target)) return;

        let current = 0;
        const duration = 3000;
        const frames = 60;
        const increment = target / frames;
        let frame = 0;

        const interval = setInterval(() => {
            frame++;
            current += increment;

            counter.textContent = current.toFixed(target % 1 !== 0 ? 1 : 0) + suffix;

            if (frame >= frames) {
                counter.textContent = target + suffix;
                clearInterval(interval);
            }
        }, duration / frames);
    });
}

let started = false;
const section = document.querySelector("section");

window.addEventListener("scroll", () => {
    if (started) return;

    const sectionPos = section.getBoundingClientRect();
    if (sectionPos.top < window.innerHeight * 0.8) {
        started = true;
        animateCounters();
    }
});
</script>



</body>
</html>