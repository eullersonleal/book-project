<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AutorRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AutorRepository::class)]
#[ORM\Table(name: 'Autor')]
class Autor {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'CodAu', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'Nome', type: 'string', length: 40)]
    #[Assert\NotBlank(
        message: 'Informe o nome do autor.',
    )]
    #[Assert\Length(
        max: 40,
        maxMessage: 'O nome deve ter no máximo {{ limit }} caracteres.',
    )]
    private string $nome = "";

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }
}