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
  document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    const ulMenu = document.getElementById("ul-menu");
    
    // 1. Definição do caminho atual e da página inicial
    const currentPath = window.location.pathname;
    // Ajuste: Certifique-se de que a verificação de caminhos com e sem barra final funcione
    const normalizedPath = currentPath.endsWith('/') && currentPath.length > 1 ? currentPath.slice(0, -1) : currentPath;

    const isHomePage = normalizedPath === '/eletronicoverde' || normalizedPath === '/eletronicoverde/';
    
    // Define a cor inicial baseada na página
    if (isHomePage) {
      ulMenu.classList.add("text-white", "text-shadow-xl");
    } else {
      ulMenu.classList.add("text-black");
    }

    // ----------------------------------------------------
    // 2. Lógica de Destaque do Link Ativo (Movida para DENTRO do DOMContentLoaded)
    // ----------------------------------------------------
    const navLinks = ulMenu.querySelectorAll('a');
    
    navLinks.forEach(link => {
        // Pega o caminho do link (ex: /eletronicoverde/materiais-aceitos)
        const linkPath = new URL(link.href).pathname; 
        
        // Normaliza o linkPath para lidar com barras finais, se necessário
        const normalizedLinkPath = linkPath.endsWith('/') && linkPath.length > 1 ? linkPath.slice(0, -1) : linkPath;

        // Verifica se o linkPath corresponde ao caminho atual normalizado
        if (normalizedPath === normalizedLinkPath) {
            // Se o link corresponde à página atual, aplica o destaque:
            link.classList.add("text-primary"); // Classe Tailwind
            link.classList.remove("hover:text-primary"); // Remove o hover
        } else {
            // Garante que o link não-ativo tenha a classe hover
            link.classList.add("hover:text-primary");
        }
    });
    // ----------------------------------------------------

    window.addEventListener("scroll", function () {
      if (window.scrollY > 50) {
        navbar.classList.add("border", "border-[#d2d2d2cc]", "m-3", "bg-[#ffffff59]", "shadow-lg", "backdrop-blur-md");
        if (isHomePage) {
          ulMenu.classList.remove("text-white", "text-shadow-xl");
          // Re-aplica a classe de texto preto, mas com cuidado para não sobrescrever o text-primary do link ativo
          navLinks.forEach(link => {
              if (!link.classList.contains('text-primary')) {
                  link.classList.remove('text-white', 'text-shadow-xl');
                  link.classList.add('text-black');
              }
          });

        }
      } else {
        navbar.classList.remove("border", "border-[#d2d2d2cc]", "m-3", "bg-[#ffffff59]", "shadow-lg", "backdrop-blur-md");
        if (isHomePage) {
          ulMenu.classList.remove("text-black");
          // Re-aplica a classe de texto branco/shadow, exceto no link ativo (text-primary)
          navLinks.forEach(link => {
              if (!link.classList.contains('text-primary')) {
                  link.classList.remove('text-black');
                  link.classList.add('text-white', 'text-shadow-xl');
              }
          });
        }
      }
    });
});

window.addEventListener('scroll', function () {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;
    
    // Adicione esta verificação, pois o elemento pode não existir em todas as páginas se for global
    const scrollProgress = document.getElementById('scroll-progress');
    if (scrollProgress) {
      scrollProgress.style.width = scrollPercent + '%';
    }
});
</script>

<div class="fixed top-0 z-50 w-full flex justify-center mx-auto">
  <div id="navbar" class="container py-2 flex flex-row justify-between items-center relative z-10 rounded-2xl p-5 px-8 transition-all duration-300 overflow-hidden">
    <a href="/eletronicoverde" class="group transition-all duration-150 h-fit">
      <h1 class="text-xl font-bold flex flex-row items-center gap-3.5">
        <img src="<?= ASSETS_URL ?>/images/Logo.png" alt="Logo Eletrônico Verde" class="max-w-15 transition-all duration-150" />
        <span id="logo" class="bg-primary text-white p-2 w-fit h-fit rounded-3xl rounded-tl-none border-2 border-primary relative overflow-hidden z-1
        group-hover:rounded-tr-sm group-hover:rounded-tl-3xl group-hover:text-primary transition-all duration-150
        before:absolute before:h-full before:-z-1 before:w-0 group-hover:before:w-full before:bg-white before:bottom-0 before:left-0 before:transition-all before:duration-250">
          Eletrônico Verde
        </span>
      </h1>
    </a>
    
    <ul id="ul-menu" class="flex flex-row gap-10 font-medium text-lg">
      <li class="relative group">
        <a href="/eletronicoverde" class="hover:text-primary transition-all duration-150">Início</a>
        <span class="nav-indicator"></span>
      </li>
      <li class="relative group">
        <a href="<?= BASE_URL ?>/pontos-coleta" class="hover:text-primary transition-all duration-150">Pontos de Coleta</a>
        <span class="nav-indicator"></span>
      </li>
      <li class="relative group">
        <a href="<?= BASE_URL?>/materiais-aceitos" class="hover:text-primary transition-all duration-150">Materiais Aceitos</a>
        <span class="nav-indicator"></span>
      </li>
      <li class="relative group">
        <a href="<?= BASE_URL?>/reciclagem" class="hover:text-primary transition-all duration-150">Reciclagem</a>
        <span class="nav-indicator"></span>
      </li>
    </ul>
    
    <div id="scroll-progress" style="position: fixed; bottom: 0; left: 0; height: 4px; width: 0; background-color: var(--color-primary); z-index: 9999; transition: width 0.1s ease-out;"></div>
  </div>
</div>