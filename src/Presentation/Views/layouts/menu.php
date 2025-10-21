<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    const logo = document.getElementById("logo");
    const ulMenu = document.getElementById("ul-menu");

    window.addEventListener("scroll", function () {
      if (window.scrollY > 50) {
        navbar.classList.add("border", "border-[#d2d2d2cc]", "m-3", "bg-[#ffffff59]", "shadow-lg", "backdrop-blur-md");
        logo.classList.add("text-black");
        ulMenu.classList.remove("text-white", "text-shadow-xl");
        ulMenu.classList.add("text-black");
      } else {
        navbar.classList.remove("border", "border-[#d2d2d2cc]", "m-3", "bg-[#ffffff59]", "shadow-lg", "backdrop-blur-md");
        logo.classList.remove("text-black");
        ulMenu.classList.add("text-white", "text-shadow-xl");
        ulMenu.classList.remove("text-black");
      }
    });
  });

  window.addEventListener('scroll', function () {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;
    document.getElementById('scroll-progress').style.width = scrollPercent + '%';
  });
</script>

<div class="fixed top-0 z-50 w-full flex justify-center mx-auto">
  <div id="navbar" class="container py-2 flex flex-row justify-between items-center relative z-10 rounded-2xl p-5 px-8 transition-all duration-300 overflow-hidden">
    <a href="home" class="group transition-all duration-150 h-fit">
      <h1 class="text-xl font-bold flex flex-row items-center gap-3.5">
        <img src="<?= ASSETS_URL ?>/images/Logo.png" alt="Logo Eletrônico Verde" class="max-w-15 transition-all duration-150" />
        <span id="logo" class="bg-primary text-white p-2 w-fit h-fit rounded-3xl rounded-tl-none border-2 border-primary relative overflow-hidden z-1
        group-hover:rounded-tr-sm group-hover:rounded-tl-3xl group-hover:text-primary transition-all duration-150
        before:absolute before:h-full before:-z-1 before:w-0 group-hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-250">
          Eletrônico Verde
        </span>
      </h1>
    </a>
    
    <ul id="ul-menu" class="flex flex-row gap-10 text-white font-medium text-lg">
      <li class="relative group">
        <a href="<?= BASE_URL ?>/" class="hover:text-primary transition-all duration-150">Início</a>
        <span class="nav-indicator"></span>
      </li>
      <li class="relative group">
        <a href="<?= BASE_URL ?>/pontos-coleta" class="hover:text-primary transition-all duration-150">Pontos de Coleta</a>
        <span class="nav-indicator"></span>
      </li>
      <li class="relative group">
        <a href="<?= BASE_URL ?>/materiais" class="hover:text-primary transition-all duration-150">Materiais Aceitos</a>
        <span class="nav-indicator"></span>
      </li>
      <li class="relative group">
        <a href="<?= BASE_URL ?>/reciclagem" class="hover:text-primary transition-all duration-150">Reciclagem</a>
        <span class="nav-indicator"></span>
      </li>
    </ul>
    
    <div id="scroll-progress" style="position: fixed; top: 0; left: 0; height: 6px; width: 0; background-color: var(--color-primary); z-index: 9999; transition: width 0.1s ease-out;"></div>
  </div>
</div>