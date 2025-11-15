<?php
// src/Application/UseCases/PontoColeta/ListarPontosColetaUseCase.php

namespace EletronicoVerde\Application\UseCases\PontoColeta;

use EletronicoVerde\Domain\Interfaces\PontoColetaRepositoryInterface;

class ListarPontosColetaUseCase
{
    private PontoColetaRepositoryInterface $pontoColetaRepository;

    public function __construct(PontoColetaRepositoryInterface $pontoColetaRepository)
    {
        $this->pontoColetaRepository = $pontoColetaRepository;
    }

    //Lista todos os pontos de coleta
    public function executar(bool $apenasAtivos = true): array
    {
        try {
            $pontosColeta = $this->pontoColetaRepository->listarTodos($apenasAtivos);

            return [
                'sucesso' => true,
                'dados' => array_map(fn($ponto) => $ponto->toArray(), $pontosColeta),
                'total' => count($pontosColeta)
            ];

        } catch (\Exception $e) {
            error_log("Erro ao listar pontos de coleta: " . $e->getMessage());
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao buscar pontos de coleta.',
                'dados' => []
            ];
        }
    }

    //Busca pontos por CEP
    public function buscarPorCep(string $cep): array
    {
        try {
            $pontosColeta = $this->pontoColetaRepository->buscarPorCep($cep);

            return [
                'sucesso' => true,
                'dados' => array_map(fn($ponto) => $ponto->toArray(), $pontosColeta),
                'total' => count($pontosColeta)
            ];

        } catch (\Exception $e) {
            error_log("Erro ao buscar por CEP: " . $e->getMessage());
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao buscar pontos de coleta.',
                'dados' => []
            ];
        }
    }
}

?>