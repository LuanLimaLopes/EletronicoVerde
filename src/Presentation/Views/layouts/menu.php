<!-- <script>
  document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    const ulMenu = document.getElementById("ul-menu");

    window.addEventListener("scroll", function () {
      if (window.scrollY > 50) {
        navbar.classList.add("border", "border-[#d2d2d2cc]", "m-3", "bg-[#ffffff59]", "shadow-lg", "backdrop-blur-md");
        ulMenu.classList.remove("text-white", "text-shadow-xl");
        ulMenu.classList.add("text-black");
      } else {
        navbar.classList.remove("border", "border-[#d2d2d2cc]", "m-3", "bg-[#ffffff59]", "shadow-lg", "backdrop-blur-md");
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
</script> -->

<script>
document.addEventListener("DOMContentLoaded", () => {

  const btn = document.getElementById("menu-btn");
  const menu = document.getElementById("mobile-menu");
  const lines = btn.querySelectorAll(".line");

  let open = false;

  const toggleMenu = () => {
    open = !open;

    // Animação hambúrguer → X
    lines[0].classList.toggle("rotate-45");
    lines[0].classList.toggle("translate-y-2");
    lines[1].classList.toggle("opacity-0");
    lines[2].classList.toggle("-rotate-45");
    lines[2].classList.toggle("-translate-y-2");

    // Menu deslizando
    menu.classList.toggle("-translate-y-full");
    menu.classList.toggle("translate-y-0");

    document.body.classList.toggle("overflow-hidden");
  };

  btn.addEventListener("click", toggleMenu);


  /* ----------------------------
        NAVBAR & ACTIVE LINK
  ----------------------------- */

  const navbar = document.getElementById("navbar");
  const navbar1 = document.getElementById("navbar-1");
  const ulMenu = document.getElementById("ul-menu");
  const navLinks = ulMenu.querySelectorAll("a");

  const current = window.location.pathname.replace(/\/$/, "");

  const isHome = current === "/eletronicoverde";

  if (isHome) {
    ulMenu.classList.add("text-white");
  }

  navLinks.forEach(link => {
    const path = new URL(link.href).pathname.replace(/\/$/, "");
    if (path === current) {
      link.classList.add("text-primary");
      link.classList.remove("hover:text-primary");
    } else {
      link.classList.add("hover:text-primary");
    }
  });

window.addEventListener("scroll", () => {
  const scrolled = window.scrollY > 50;

  // Estilos do navbar baseado no scroll
  navbar.classList.toggle("md:border", scrolled);
  navbar.classList.toggle("md:border-[#d2d2d2cc]", scrolled);
  navbar.classList.toggle("md:m-3", scrolled);
  navbar.classList.toggle("md:bg-[#ffffff59]", scrolled);
  navbar.classList.toggle("md:shadow-lg", scrolled);
  navbar.classList.toggle("md:backdrop-blur-md", scrolled);

  navbar1.classList.toggle("border-b", scrolled);
  navbar1.classList.toggle("border-[#d2d2d2cc]", scrolled);
  navbar1.classList.toggle("bg-[#ffffff59]", scrolled);
  navbar1.classList.toggle("shadow-lg", scrolled);
  navbar1.classList.toggle("backdrop-blur-md", scrolled);

  // Linhas do botão hambúrguer
  lines.forEach(line => {
    line.classList.toggle("bg-black", scrolled);
    line.classList.toggle("bg-white", !scrolled);
  });

  // Links
  if (isHome) {
    navLinks.forEach(link => {
      const isActive = link.classList.contains("text-primary");

      if (!isActive) {
        link.classList.toggle("text-black", scrolled);
        link.classList.toggle("text-white", !scrolled);
      }
    });
  }
});


  /* ----------------------------
        SCROLL PROGRESS
  ----------------------------- */

  window.addEventListener("scroll", () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;

    const scrollProgress = document.getElementById("scroll-progress");
    if (scrollProgress) scrollProgress.style.width = scrollPercent + "%";
  });

});
</script>



<div id="navbar-1"
     class="fixed top-0 z-50 w-full flex justify-between md:justify-center items-center px-3 transition-all duration-300 
     md:border-none md:bg-transparent md:shadow-none md:backdrop-blur-none">

  <div id="navbar"
       class="md:container flex flex-row justify-between items-center relative rounded-2xl py-2 md:px-5 lg:px-8
              transition-all duration-300 overflow-hidden w-fit">

    <!-- LOGO -->
    <a href="/eletronicoverde" class="group transition-all duration-150 h-fit">
      <h1 class="text-base lg:text-xl font-bold flex flex-row items-center gap-3.5">
        <img src="<?= ASSETS_URL ?>/images/Logo.png" alt="Logo Eletrônico Verde"
             class="max-w-15 transition-all duration-150" />
        
        <span id="logo"
              class="hidden sm:flex bg-primary text-white p-2 rounded-3xl rounded-tl-none border-2 border-primary relative
                     overflow-hidden z-1 transition-all duration-150
                     group-hover:text-primary group-hover:rounded-tr-sm group-hover:rounded-tl-3xl
                     before:absolute before:left-0 before:bottom-0 before:h-full before:w-0 before:bg-white
                     before:-z-1 before:transition-all before:duration-250 group-hover:before:w-full">
          Eletrônico Verde
        </span>
      </h1>
    </a>

    <!-- MENU DESKTOP -->
    <ul id="ul-menu" class="hidden md:flex flex-row gap-5 lg:gap-10 font-medium text-base lg:text-lg transition-all duration-300">
      <li><a href="/eletronicoverde" class="nav-item">Início</a></li>
      <li><a href="<?= BASE_URL ?>/pontos-coleta" class="nav-item">Pontos de Coleta</a></li>
      <li><a href="<?= BASE_URL ?>/materiais-aceitos" class="nav-item">Materiais Aceitos</a></li>
      <li><a href="<?= BASE_URL ?>/reciclagem" class="nav-item">Reciclagem</a></li>
    </ul>

    <!-- SCROLL PROGRESS -->
    <div id="scroll-progress"
         class="fixed bottom-0 left-0 h-1 w-0 bg-primary z-10 transition-[width] duration-100">
    </div>
  </div>

  <!-- BOTÃO MOBILE -->
  <button id="menu-btn" class="md:hidden flex flex-col gap-1.5 z-[9999]">
    <span class="line w-8 h-1 bg-white rounded-full transition-all duration-300"></span>
    <span class="line w-8 h-1 bg-white rounded-full transition-all duration-300"></span>
    <span class="line w-8 h-1 bg-white rounded-full transition-all duration-300"></span>
  </button>

  <!-- MENU MOBILE (Opção A — Slide de cima) -->
  <nav id="mobile-menu"
       class="fixed top-0 left-0 w-screen h-screen bg-third text-white backdrop-blur-md flex flex-col px-10 justify-center
              text-3xl gap-8 transform -translate-y-full transition-transform duration-300 z-[90] font-bold">
    <h1 class="text-base lg:text-xl font-bold flex flex-row items-center gap-3.5">
      <img src="<?= ASSETS_URL ?>/images/Logo.png" alt="Logo Eletrônico Verde"
           class="max-w-15 transition-all duration-150" />
      
      <span id="logo"
            class="bg-primary text-white p-2 rounded-3xl rounded-tl-none border-2 border-primary relative
                   overflow-hidden z-1 transition-all duration-150
                   group-hover:text-primary group-hover:rounded-tr-sm group-hover:rounded-tl-3xl
                   before:absolute before:left-0 before:bottom-0 before:h-full before:w-0 before:bg-white
                   before:-z-1 before:transition-all before:duration-250 group-hover:before:w-full">
        Eletrônico Verde
      </span>
    </h1>

    <a href="/eletronicoverde">Início</a>
    <a href="<?= BASE_URL ?>/pontos-coleta">Pontos de Coleta</a>
    <a href="<?= BASE_URL ?>/materiais-aceitos">Materiais Aceitos</a>
    <a href="<?= BASE_URL ?>/reciclagem">Reciclagem</a>
  </nav>

</div>