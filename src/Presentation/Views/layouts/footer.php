<footer class="bg-primary relative w-full h-[30rem] md:h-[25rem] flex justify-center z-0">
  <div class="bg-primary fixed bottom-0 h-[30rem] md:h-[25rem] w-full justify-between p-10 flex flex-col gap-10">


    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start items-start gap-10">


      <a href="/EletronicoVerde" class="group transition-all duration-150">
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
            <a href="/EletronicoVerde"
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

// Contador animado
document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".counter");

  function animateCounter(counter) {
    const target = parseFloat(counter.dataset.target);
    const suffix = counter.dataset.suffix || "";
    const duration = 2000;
    const startTime = performance.now();

    const isDecimal = counter.dataset.isDecimal === "true";

    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);

      let value = target * progress;

      // Se o número original tinha vírgula, mantém 1 casa decimal
      if (isDecimal) {
        value = (value).toFixed(1).replace(".", ",");
      } else {
        value = Math.floor(value);
      }

      counter.textContent = value + suffix;

      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }

    requestAnimationFrame(update);
  }

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const counter = entry.target;

        let raw = counter.textContent.trim();

        if (raw.includes(",")) {
          counter.dataset.isDecimal = "true";
          counter.dataset.target = raw.replace("%", "").replace(".", "").replace(",", ".");
        } else {
          counter.dataset.isDecimal = "false";
          counter.dataset.target = raw.replace(/\D/g, "");
        }

        animateCounter(counter);
        obs.unobserve(counter);
      }
    });
  }, { threshold: 0.3 });

  counters.forEach(counter => observer.observe(counter));
});

</script>



</body>
</html>