eletronicoverde/
│
├──Doc
│   ├──  README.md
│   ├── .gitignore
│
├── config/
│   ├── autoload.php
│   ├── database.php          # Configuração do SQLite
│   ├── constants.php          # Constantes da aplicação
│   └── routes.php             # Definição de rotas
│
├── src/
│   ├── Domain/                # Camada de Domínio (Regras de Negócio)
│   │   ├── Entities/
│   │   │   ├── PontoColeta.php
│   │   │   ├── Material.php
│   │   │   └── Usuario.php
│   │   │
│   │   └── Interfaces/        # Contratos/Interfaces
│   │       ├── PontoColetaRepositoryInterface.php
│   │       ├── MaterialRepositoryInterface.php
│   │       └── UsuarioRepositoryInterface.php
│   │
│   ├── Application/           # Camada de Aplicação (Casos de Uso)
│   │   ├── UseCases/
│   │   │   ├── PontoColeta/
│   │   │   │   ├── CriarPontoColetaUseCase.php
│   │   │   │   ├── ListarPontosColetaUseCase.php
│   │   │   │   ├── EditarPontoColetaUseCase.php
│   │   │   │   └── ExcluirPontoColetaUseCase.php
│   │   │   │
│   │   │   ├── Material/
│   │   │   │   ├── CriarMaterialUseCase.php
│   │   │   │   └── ListarMateriaisUseCase.php
│   │   │   │
│   │   │   └── Usuario/
│   │   │       ├── AutenticarUsuarioUseCase.php
│   │   │       └── CriarUsuarioUseCase.php
│   │   │
│   │   └── DTOs/               # Data Transfer Objects
│   │       ├── PontoColetaDTO.php
│   │       ├── MaterialDTO.php
│   │       └── UsuarioDTO.php
│   │
│   ├── Infrastructure/         # Camada de Infraestrutura
│   │   ├── Database/
│   │   │   ├── SQLiteConnection.php
│   │   │   └── migrations/
│   │   │       └── create_tables.sql
│   │   │
│   │   ├── Repositories/
│   │   │   ├── SQLitePontoColetaRepository.php
│   │   │   ├── SQLiteMaterialRepository.php
│   │   │   └── SQLiteUsuarioRepository.php
│   │   │
│   │   └── Security/
│   │       ├── Authentication.php
│   │       ├── PasswordHasher.php
│   │       └── CSRF.php
│   │
│   └── Presentation/           # Camada de Apresentação
│       ├── Controllers/
│       │   ├── HomeController.php
│       │   ├── PontoColetaController.php
│       │   ├── MaterialController.php
│       │   ├── ReciclagemController.php
│       │   └── AuthController.php
│       │
│       ├── Views/
│       │   ├── layouts/
│       │   │   ├── header.php
│       │   │   ├── footer.php
│       │   │   └── menu.php
│       │   │
│       │   ├── home/
│       │   │   └── index.php
│       │   │
│       │   ├── pontos-coleta/
│       │   │   ├── index.php
│       │   │   ├── cadastro.php
│       │   │   ├── consultar.php
│       │   │   └── editar.php
│       │   │
│       │   ├── materiais/
│       │   │   └── index.php
│       │   │
│       │   ├── reciclagem/
│       │   │   └── index.php
│       │   │
│       │   └── auth/
│       │       ├── login.php
│       │       └── acesso-restrito.php
│       │
│       └── Helpers/
│           ├── ViewHelper.php
│           └── FormHelper.php
│
├── public/            Pasta pública (único ponto de entrada)
│   │
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css
│   │   │
│   │   ├── js/
│   │   │   └── main.js
│   │   │****
│   │   └── images/
│   │       └── (todas as imagens)
│   │
│   └── uploads/               # Arquivos enviados
│
├── storage/
│   ├── database/
│   │   └── eletronico_verde.db  # Banco SQLite
│   │
│   └── logs/
│       └── app.log
│
├── tests/                      # Testes (opcional)
│   ├── Unit/
│   └── Integration/
│
│
├── composer.json
└── index.php
└── .htacess