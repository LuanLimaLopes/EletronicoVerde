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
            // Validar dados obrigatórios
            $this->validarDados($dto);

            // Buscar ponto existente
            $pontoColeta = $this->pontoColetaRepository->buscarPorId($id);

            if (!$pontoColeta) {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Ponto de coleta não encontrado.'
                ];
            }

            // Atualizar TODOS os dados do ponto de coleta
            $pontoColeta->setEmpresa($dto->empresa);
            $pontoColeta->setEndereco($dto->endereco);
            $pontoColeta->setNumero($dto->numero);
            $pontoColeta->setComplemento($dto->complemento);
            $pontoColeta->setCep($dto->cep);
            $pontoColeta->setHoraInicio($dto->horaInicio);
            $pontoColeta->setHoraEncerrar($dto->horaEncerrar);
            $pontoColeta->setTelefone($dto->telefone);
            $pontoColeta->setEmail($dto->email);
            
            // Atualizar coordenadas geográficas
            $pontoColeta->setLatitude($dto->latitude);
            $pontoColeta->setLongitude($dto->longitude);
            
            // Atualizar materiais
            // Limpa materiais antigos
            $pontoColeta->setMateriais([]);
            
            if (!empty($dto->materiaisIds)) {
                $materiais = $this->materialRepository->buscarPorIds($dto->materiaisIds);
                
                if (count($materiais) !== count($dto->materiaisIds)) {
                    return [
                        'sucesso' => false,
                        'mensagem' => 'Um ou mais materiais não foram encontrados.'
                    ];
                }

                foreach ($materiais as $material) {
                    $pontoColeta->adicionarMaterial($material);
                }
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

    /**
     * Valida os dados do DTO
     */
    private function validarDados(PontoColetaDTO $dto): void
    {
        if (empty($dto->empresa)) {
            throw new \InvalidArgumentException('Nome da empresa é obrigatório.');
        }

        if (empty($dto->endereco)) {
            throw new \InvalidArgumentException('Endereço é obrigatório.');
        }

        if (empty($dto->numero)) {
            throw new \InvalidArgumentException('Número é obrigatório.');
        }

        if (empty($dto->cep)) {
            throw new \InvalidArgumentException('CEP é obrigatório.');
        }

        if (empty($dto->telefone)) {
            throw new \InvalidArgumentException('Telefone é obrigatório.');
        }

        if (empty($dto->email)) {
            throw new \InvalidArgumentException('Email é obrigatório.');
        }

        if (empty($dto->horaInicio)) {
            throw new \InvalidArgumentException('Horário de início é obrigatório.');
        }

        if (empty($dto->horaEncerrar)) {
            throw new \InvalidArgumentException('Horário de encerramento é obrigatório.');
        }
    }
}

?>