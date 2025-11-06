<footer class="bg-primary relative w-full h-[20rem] flex justify-center z-0 ">
  <div class="bg-primary fixed bottom-0 h-[20rem] w-full rounded-t-4xl flex flex-col justify-between p-10 ">
    <div class="flex flex-row w-full h-fit justify-between items-start">
      <a href="/eletronicoverde" class="group transition-all duration-150 h-fit">
        <h1 class="text-xl font-bold flex flex-row items-center gap-3.5">
          <img src="<?= ASSETS_URL ?>/images/Logo branca.png" alt="Logo Eletrônico Verde" class="max-w-15 transition-all duration-150" />
          <span class="bg-white text-primary p-2 w-fit h-fit rounded-3xl rounded-tl-none border-2 border-white relative overflow-hidden z-1
          group-hover:rounded-tr-sm group-hover:rounded-tl-3xl group-hover:text-white transition-all duration-150
          before:absolute before:h-full before:-z-1 before:w-0 group-hover:before:w-full before:bg-primary before:bottom-0 before:left-0 before:transition-all before:duration-250">
            Eletrônico Verde
          </span>
        </h1>
      </a>
      
      <div class="gap-10 flex flex-col items-start ">
        <ul class="flex flex-col gap-2 text-white text-lg h-fit">
          <li class="relative group">
            <a href="/eletronicoverde" class="relative transition-all duration-150 before:absolute before:h-[1px] before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-150">Início</a>
          </li>
          <li class="relative group">
            <a href="<?= BASE_URL?>/pontos-coleta" class="relative transition-all duration-150 before:absolute before:h-[1px] before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-150">Pontos de Coleta</a>
          </li>
          <li class="relative group">
            <a href="<?= BASE_URL?>/materiais-aceitos" class="relative transition-all duration-150 before:absolute before:h-[1px] before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-150">Materiais Aceitos</a>
          </li>
          <li class="relative group">
            <a href="<?= BASE_URL?>/reciclagem" class="relative transition-all duration-150 before:absolute before:h-[1px] before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-150">Reciclagem</a>
          </li>
        </ul>
        <div>
          <a href="<?= BASE_URL?>/login" class="float-end text-white border-1 border-white p-2 rounded-4xl relative transition-all duration-300 overflow-hidden hover:text-primary z-1
          before:absolute before:h-full before:-z-1 before:w-0 hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-300">Acesso restrito</a>
        </div>
      </div>
    </div>
    <p class="w-full text-center text-white">© 2025 Eletrônico Verde. Todos os direitos reservados.</p>
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
</script>

</body>
</html>