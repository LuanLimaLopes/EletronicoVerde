<?php
// src/Application/UseCases/PontoColeta/CriarPontoColetaUseCase.php

namespace EletronicoVerde\Application\UseCases\PontoColeta;

use EletronicoVerde\Domain\Entities\PontoColeta;
use EletronicoVerde\Domain\Interfaces\PontoColetaRepositoryInterface;
use EletronicoVerde\Domain\Interfaces\MaterialRepositoryInterface;
use EletronicoVerde\Application\DTOs\PontoColetaDTO;

class CriarPontoColetaUseCase
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

    //Executa o caso de uso de criação de ponto de coleta
     public function executar(PontoColetaDTO $dto): array
    {
        try {
            // Validar dados obrigatórios
            $this->validarDados($dto);

            // Criar entidade PontoColeta
            $pontoColeta = new PontoColeta(
                $dto->empresa,
                $dto->endereco,
                $dto->numero,
                $dto->cep,
                $dto->horaInicio,
                $dto->horaEncerrar,
                $dto->telefone,
                $dto->email,
                $dto->complemento,
                $dto->latitude,
                $dto->longitude,
                $dto->cidade,
                $dto->estado,
                $dto->bairro
            );

            // Adicionar materiais se fornecidos
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

            // Salvar no repositório
            $sucesso = $this->pontoColetaRepository->salvar($pontoColeta);

            if ($sucesso) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Ponto de coleta cadastrado com sucesso!',
                    'id' => $pontoColeta->getId()
                ];
            }

            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao cadastrar ponto de coleta. Tente novamente.'
            ];

        } catch (\InvalidArgumentException $e) {
            return [
                'sucesso' => false,
                'mensagem' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            error_log("Erro ao criar ponto de coleta: " . $e->getMessage());
            return [
                'sucesso' => false,
                'mensagem' => 'Erro inesperado ao cadastrar ponto de coleta.'
            ];
        }
    }

    //Valida os dados do DTO
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