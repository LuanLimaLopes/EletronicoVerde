
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title><?= $pageTitle ?? 'Eletrônico Verde' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=north_east" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= ASSETS_URL ?>/images/favicon.ico">
    
    <!-- CSS Customizado -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/style.css">
    
    <!-- Tailwind Config -->
    <style type="text/tailwindcss">
      @theme {
        --font-inter: 'Inter', sans-serif;
        --font-poppins: 'Poppins', sans-serif;
        --font-dm-serif-display: 'DM Serif Display', serif;
        --font-league-spartan: "League Spartan", sans-serif;
        --font-inter-tight: "Inter Tight", sans-serif;

        --color-primary: #04A777;
        --color-second: #337357;
        --color-third: #283D3B;
        --color-fourth: #D3FFF2;
        --color-whitey: #ededed;
        --color-azul: #007BFF;
        --color-amarelo: #F7DC6F;
        --color-amarelo-dark: #c8b25b;
        --color-cinza: #141414;
        --color-cinza-txt: #434343;
        --color-gradient: #0dd89b;
      }

      @layer utilities {
        .text-shadow { text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); }
        .text-shadow-md { text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.7); }
        .text-shadow-lg { text-shadow: 6px 6px 12px rgba(0, 0, 0, 0.9); }
        .text-shadow-xl { text-shadow: 1px 1px 10px rgba(0, 0, 0, 0.9); }
        .text-shadow-xl-w { text-shadow: 1px 1px 10px rgba(255, 255, 255, 0.9); }
        .nav-indicator {
          @apply absolute left-1/2 -translate-1/2 bottom-[-15px] w-2 h-2 bg-primary rounded-full transition-transform duration-200 scale-0;
        }
        .group:hover .nav-indicator { @apply scale-100; }
      }
    </style>
</head>
<body class="font-inter-tight overflow-x-hidden">

<?php require_once __DIR__ . '/menu.php'; ?>

</body>
</html>