<?php
// src/Application/DTOs/PontoColetaDTO.php

namespace EletronicoVerde\Application\DTOs;

class PontoColetaDTO
{
    public string $empresa;
    public string $endereco;
    public string $numero;
    public ?string $complemento;
    public string $cep;
    public string $horaInicio;
    public string $horaEncerrar;
    public string $telefone;
    public string $email;
    public ?float $latitude;
    public ?float $longitude;
    public array $materiaisIds;

    public function __construct(array $dados)
    {
        $this->empresa = $dados['empresa'] ?? '';
        $this->endereco = $dados['endereco'] ?? '';
        $this->numero = $dados['numero'] ?? '';
        $this->complemento = $dados['complemento'] ?? null;
        $this->cep = $dados['cep'] ?? '';
        $this->horaInicio = $dados['hora_inicio'] ?? '';
        $this->horaEncerrar = $dados['hora_encerrar'] ?? '';
        $this->telefone = $dados['telefone'] ?? '';
        $this->email = $dados['email'] ?? '';
        $this->latitude = isset($dados['latitude']) ? (float) $dados['latitude'] : null;
        $this->longitude = isset($dados['longitude']) ? (float) $dados['longitude'] : null;
        $this->materiaisIds = $dados['materiais_ids'] ?? [];
    }

    /**
     * Cria DTO a partir de dados POST
     */
    public static function fromPost(array $post): self
    {
        $materiaisIds = [];
        
        // Suporta tanto array quanto string separada por vírgula
        if (isset($post['materiais_ids'])) {
            if (is_array($post['materiais_ids'])) {
                $materiaisIds = array_map('intval', $post['materiais_ids']);
            } elseif (is_string($post['materiais_ids'])) {
                $materiaisIds = array_map('intval', explode(',', $post['materiais_ids']));
            }
        }

        return new self([
            'empresa' => $post['txtempresa'] ?? $post['empresa'] ?? '',
            'endereco' => $post['txtendereco'] ?? $post['endereco'] ?? '',
            'numero' => $post['txtnumero'] ?? $post['numero'] ?? '',
            'complemento' => $post['txtcomplemento'] ?? $post['complemento'] ?? null,
            'cep' => $post['txtcep'] ?? $post['cep'] ?? '',
            'hora_inicio' => $post['txthora_inicio'] ?? $post['hora_inicio'] ?? '',
            'hora_encerrar' => $post['txthora_encerrar'] ?? $post['hora_encerrar'] ?? '',
            'telefone' => $post['txttelefone'] ?? $post['telefone'] ?? '',
            'email' => $post['txtemail'] ?? $post['email'] ?? '',
            'latitude' => $post['latitude'] ?? null,
            'longitude' => $post['longitude'] ?? null,
            'materiais_ids' => $materiaisIds
        ]);
    }
}