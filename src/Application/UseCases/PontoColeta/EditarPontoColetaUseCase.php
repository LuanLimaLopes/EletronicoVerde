<?php

// src/Application/UseCases/PontoColeta/EditarPontoColetaUseCase.php

namespace EletronicoVerde\Application\UseCases\PontoColeta;

use EletronicoVerde\Domain\Interfaces\PontoColetaRepositoryInterface;
use EletronicoVerde\Domain\Interfaces\MaterialRepositoryInterface;
use EletronicoVerde\Application\DTOs\PontoColetaDTO;

class EditarPontoColetaUseCase
{
    private PontoColetaRepositoryInterface $pontoColetaRepository;
    private MaterialRepositoryInterface $materialRepository;

    public function __construct(
        PontoColetaRepositoryInterface $pontoColetaRepository,
        MaterialRepositoryInterface $materialRepository
    ) {
        $this->pontoColetaRepository = $pontoColetaRepository;
        $this->materialRepository = $materialRepository;
    }

    /**
     * Busca ponto de coleta por ID para edição
     */
    public function buscarPorId(int $id): array
    {
        try {
            $pontoColeta = $this->pontoColetaRepository->buscarPorId($id);

            if (!$pontoColeta) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Ponto de coleta não encontrado.'
                ];
            }

            return [
                'sucesso' => true,
                'dados' => $pontoColeta->toArray()
            ];

        } catch (\Exception $e) {
            error_log("Erro ao buscar ponto de coleta: " . $e->getMessage());
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao buscar ponto de coleta.'
            ];
        }
    }

    /**
     * Executa a atualização do ponto de coleta
     */
    public function executar(int $id, PontoColetaDTO $dto): array
    {
        try {
            // Buscar ponto existente
            $pontoColeta = $this->pontoColetaRepository->buscarPorId($id);

            if (!$pontoColeta) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Ponto de coleta não encontrado.'
                ];
            }

            // Atualizar dados
            $pontoColeta->setEmpresa($dto->empresa);
            $pontoColeta->setEndereco($dto->endereco);
            $pontoColeta->setCep($dto->cep);
            $pontoColeta->setTelefone($dto->telefone);
            $pontoColeta->setEmail($dto->email);
            
            // Atualizar materiais
            if (!empty($dto->materiaisIds)) {
                $materiais = $this->materialRepository->buscarPorIds($dto->materiaisIds);
                $pontoColeta->setMateriais($materiais);
            }

            // Salvar alterações
            $sucesso = $this->pontoColetaRepository->atualizar($pontoColeta);

            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Ponto de coleta atualizado com sucesso!'
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar ponto de coleta.'
            ];

        } catch (\InvalidArgumentException $e) {
            return [
                'sucesso' => false,
                'mensagem' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            error_log("Erro ao editar ponto de coleta: " . $e->getMessage());
            return [
                'sucesso' => false,
                'mensagem' => 'Erro inesperado ao atualizar ponto de coleta.'
            ];
        }
    }
}