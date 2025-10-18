<?php

// src/Application/UseCases/PontoColeta/ExcluirPontoColetaUseCase.php

namespace EletronicoVerde\Application\UseCases\PontoColeta;

use EletronicoVerde\Domain\Interfaces\PontoColetaRepositoryInterface;

class ExcluirPontoColetaUseCase
{
    private PontoColetaRepositoryInterface $pontoColetaRepository;

    public function __construct(PontoColetaRepositoryInterface $pontoColetaRepository)
    {
        $this->pontoColetaRepository = $pontoColetaRepository;
    }

    /**
     * Executa a exclusão do ponto de coleta
     */
    public function executar(int $id): array
    {
        try {
            // Verificar se existe
            $pontoColeta = $this->pontoColetaRepository->buscarPorId($id);

            if (!$pontoColeta) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Ponto de coleta não encontrado.'
                ];
            }

            // Excluir
            $sucesso = $this->pontoColetaRepository->excluir($id);

            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Ponto de coleta excluído com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir ponto de coleta.'
            ];

        } catch (\Exception $e) {
            error_log("Erro ao excluir ponto de coleta: " . $e->getMessage());
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao excluir ponto de coleta.'
            ];
        }
    }
}