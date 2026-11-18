<?php

declare(strict_types=1);    

namespace App\Entity;

use App\Repository\AssuntoRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssuntoRepository::class)]
#[ORM\Table(name: 'Assunto')]
class Assunto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'codAs', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'Descricao', type: 'string', length: 20)]
    #[Assert\NotBlank(
        message: 'Informe a descrição do assunto.'
    )]
    #[Assert\Length(
        max: 20,
        maxMessage: 'A descrição deve ter no máximo {{ limit }} caracteres.'
    )]
    private string $descricao = "";

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

}