<?php
// src/Domain/Entities/PontoColeta.php

namespace EletronicoVerde\Domain\Entities;

class PontoColeta
{
    private ?int $id;
    private string $empresa;
    private string $endereco;
    private string $numero;
    private ?string $complemento;
    private string $cep;
    private string $horaInicio;
    private string $horaEncerrar;
    private string $telefone;
    private string $email;
    private ?float $latitude;
    private ?float $longitude;
    private bool $ativo;
    private array $materiais = [];
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        string $empresa,
        string $endereco,
        string $numero,
        string $cep,
        string $horaInicio,
        string $horaEncerrar,
        string $telefone,
        string $email,
        ?string $complemento = null,
        ?float $latitude = null,
        ?float $longitude = null,
        bool $ativo = true,
        ?int $id = null
    ) {
        $this->empresa = $empresa;
        $this->endereco = $endereco;
        $this->numero = $numero;
        $this->cep = $this->sanitizeCep($cep);
        $this->horaInicio = $horaInicio;
        $this->horaEncerrar = $horaEncerrar;
        $this->telefone = $this->sanitizeTelefone($telefone);
        $this->email = $email;
        $this->complemento = $complemento;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->ativo = $ativo;
        $this->id = $id;
        
        $this->validate();
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getEmpresa(): string { return $this->empresa; }
    public function getEndereco(): string { return $this->endereco; }
    public function getNumero(): string { return $this->numero; }
    public function getComplemento(): ?string { return $this->complemento; }
    public function getCep(): string { return $this->cep; }
    public function getHoraInicio(): string { return $this->horaInicio; }
    public function getHoraEncerrar(): string { return $this->horaEncerrar; }
    public function getTelefone(): string { return $this->telefone; }
    public function getEmail(): string { return $this->email; }
    public function getLatitude(): ?float { return $this->latitude; }
    public function getLongitude(): ?float { return $this->longitude; }
    public function isAtivo(): bool { return $this->ativo; }
    public function getMateriais(): array { return $this->materiais; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    
    public function setEmpresa(string $empresa): void 
    { 
        $this->empresa = $empresa;
        $this->validate();
    }
    
    public function setEndereco(string $endereco): void 
    { 
        $this->endereco = $endereco;
        $this->validate();
    }
    
    public function setCep(string $cep): void 
    { 
        $this->cep = $this->sanitizeCep($cep);
        $this->validate();
    }
    
    public function setTelefone(string $telefone): void 
    { 
        $this->telefone = $this->sanitizeTelefone($telefone);
        $this->validate();
    }
    
    public function setEmail(string $email): void 
    { 
        $this->email = $email;
        $this->validate();
    }

    public function setLatitude(?float $latitude): void { $this->latitude = $latitude; }
    public function setLongitude(?float $longitude): void { $this->longitude = $longitude; }
    public function setAtivo(bool $ativo): void { $this->ativo = $ativo; }
    public function setMateriais(array $materiais): void { $this->materiais = $materiais; }
    public function setCreatedAt(string $createdAt): void { $this->createdAt = $createdAt; }
    public function setUpdatedAt(string $updatedAt): void { $this->updatedAt = $updatedAt; }

    /**
     * Adiciona um material à lista de materiais aceitos
     */
    public function adicionarMaterial(Material $material): void
    {
        if (!$this->temMaterial($material->getId())) {
            $this->materiais[] = $material;
        }
    }

    /**
     * Remove um material da lista
     */
    public function removerMaterial(int $materialId): void
    {
        $this->materiais = array_filter(
            $this->materiais, 
            fn($m) => $m->getId() !== $materialId
        );
    }

    /**
     * Verifica se possui um material específico
     */
    public function temMaterial(int $materialId): bool
    {
        foreach ($this->materiais as $material) {
            if ($material->getId() === $materialId) {
                return true;
            }
        }
        return false;
    }

    /**
     * Valida os dados da entidade
     */
    private function validate(): void
    {
        if (empty($this->empresa)) {
            throw new \InvalidArgumentException("Nome da empresa é obrigatório.");
        }

        if (empty($this->endereco)) {
            throw new \InvalidArgumentException("Endereço é obrigatório.");
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email inválido.");
        }

        if (strlen($this->cep) !== 8) {
            throw new \InvalidArgumentException("CEP inválido. Deve conter 8 dígitos.");
        }
    }

    /**
     * Remove caracteres especiais do CEP
     */
    private function sanitizeCep(string $cep): string
    {
        return preg_replace('/[^0-9]/', '', $cep);
    }

    /**
     * Remove caracteres especiais do telefone
     */
    private function sanitizeTelefone(string $telefone): string
    {
        return preg_replace('/[^0-9]/', '', $telefone);
    }

    /**
     * Retorna endereço completo formatado
     */
    public function getEnderecoCompleto(): string
    {
        $endereco = $this->endereco . ', ' . $this->numero;
        
        if ($this->complemento) {
            $endereco .= ' - ' . $this->complemento;
        }
        
        return $endereco . ' - CEP: ' . $this->getCepFormatado();
    }

    /**
     * Retorna CEP formatado (00000-000)
     */
    public function getCepFormatado(): string
    {
        return substr($this->cep, 0, 5) . '-' . substr($this->cep, 5);
    }

    /**
     * Retorna telefone formatado
     */
    public function getTelefoneFormatado(): string
    {
        $length = strlen($this->telefone);
        
        if ($length === 11) {
            // Celular: (00) 00000-0000
            return '(' . substr($this->telefone, 0, 2) . ') ' . 
                   substr($this->telefone, 2, 5) . '-' . 
                   substr($this->telefone, 7);
        } elseif ($length === 10) {
            // Fixo: (00) 0000-0000
            return '(' . substr($this->telefone, 0, 2) . ') ' . 
                   substr($this->telefone, 2, 4) . '-' . 
                   substr($this->telefone, 6);
        }
        
        return $this->telefone;
    }

    /**
     * Converte para array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'empresa' => $this->empresa,
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'cep' => $this->cep,
            'hora_inicio' => $this->horaInicio,
            'hora_encerrar' => $this->horaEncerrar,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'ativo' => $this->ativo,
            'materiais' => array_map(fn($m) => $m->toArray(), $this->materiais),
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}