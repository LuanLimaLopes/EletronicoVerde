-- Migration: Criação das tabelas para Eletrônico Verde
-- Database: SQLite
-- Versão: 1.0.0

-- Tabela de Usuários (Admin)
CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Pontos de Coleta
CREATE TABLE IF NOT EXISTS pontos_coleta (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    empresa VARCHAR(200) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    numero VARCHAR(20) NOT NULL,
    complemento VARCHAR(100),
    cep VARCHAR(10) NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_encerrar TIME NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    ativo BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Materiais
CREATE TABLE IF NOT EXISTS materiais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT,
    icone VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Relacionamento (Ponto de Coleta <-> Materiais)
CREATE TABLE IF NOT EXISTS ponto_coleta_materiais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ponto_coleta_id INTEGER NOT NULL,
    material_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ponto_coleta_id) REFERENCES pontos_coleta(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materiais(id) ON DELETE CASCADE,
    UNIQUE(ponto_coleta_id, material_id)
);

-- Índices para melhor performance
CREATE INDEX IF NOT EXISTS idx_pontos_cep ON pontos_coleta(cep);
CREATE INDEX IF NOT EXISTS idx_pontos_ativo ON pontos_coleta(ativo);
CREATE INDEX IF NOT EXISTS idx_usuarios_email ON usuarios(email);
CREATE INDEX IF NOT EXISTS idx_ponto_materiais ON ponto_coleta_materiais(ponto_coleta_id, material_id);

-- Trigger para atualizar updated_at automaticamente
CREATE TRIGGER IF NOT EXISTS update_usuarios_timestamp 
AFTER UPDATE ON usuarios
BEGIN
    UPDATE usuarios SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id;
END;

CREATE TRIGGER IF NOT EXISTS update_pontos_timestamp 
AFTER UPDATE ON pontos_coleta
BEGIN
    UPDATE pontos_coleta SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id;
END;

CREATE TRIGGER IF NOT EXISTS update_materiais_timestamp 
AFTER UPDATE ON materiais
BEGIN
    UPDATE materiais SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id;
END;

-- Inserir dados iniciais de materiais
INSERT OR IGNORE INTO materiais (nome, descricao, icone) VALUES
('Celulares e Smartphones', 'Aparelhos móveis, tablets e acessórios', 'fa-mobile'),
('Computadores', 'Desktops, notebooks, monitores e periféricos', 'fa-computer'),
('Componentes Eletrônicos', 'Placas-mãe, processadores, memórias RAM, HDs', 'fa-microchip'),
('Eletrodomésticos', 'Micro-ondas, geladeiras, máquinas de lavar', 'fa-blender'),
('Baterias e Pilhas', 'Baterias de dispositivos e pilhas comuns', 'fa-battery-full'),
('Cabos e Fios', 'Cabos USB, HDMI, carregadores', 'fa-plug'),
('Periféricos', 'Teclados, mouses, fones de ouvido', 'fa-keyboard'),
('Televisores', 'TVs LCD, LED, Plasma e CRT', 'fa-tv'),
('Impressoras', 'Impressoras, scanners e multifuncionais', 'fa-print');

-- Inserir usuário admin padrão (senha: admin123)
-- Hash gerado com password_hash('admin123', PASSWORD_DEFAULT)
INSERT OR IGNORE INTO usuarios (nome, email, senha) VALUES
('Administrador', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');