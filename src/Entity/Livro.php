<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Livro')]
class Livro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'Codl', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'Titulo', type: 'string', length: 40)]
    private string $titulo = "";

    #[ORM\Column(name: 'Editora', type: 'string', length: 40)]
    private string $editora = "";

    #[ORM\Column(name: 'Edicao', type: 'integer')]
    private int $edicao = 1;

    #[ORM\Column(name: 'AnoPublicacao', type: 'string', length: 4)]
    private string $anoPublicacao = "";

    #[ORM\Column(name: 'Valor', type: 'decimal', precision: 10, scale: 2)]
    private string $valor = "0.00";


    /** @var Collection<int, Autor> */
    #[ORM\ManyToMany(targetEntity: Autor::class)]
    #[ORM\JoinTable(name: 'Livro_Autor')]
    #[ORM\JoinColumn(
        name: 'Livro_Codl', 
        referencedColumnName: 'Codl', 
        onDelete: 'CASCADE'
        )]
    #[ORM\InverseJoinColumn(
        name: 'Autor_CodAu',
        referencedColumnName: 'CodAu',
        onDelete: 'RESTRICT',
    )]
    private Collection $autores;


    /** @var Collection<int, Assunto> */
    #[ORM\ManyToMany(targetEntity: Assunto::class)]
    #[ORM\JoinTable(name: 'Livro_Assunto')]
    #[ORM\JoinColumn(
        name: 'Livro_Codl',
        referencedColumnName: 'Codl',
        onDelete: 'CASCADE',
    )]
    #[ORM\InverseJoinColumn(
        name: 'Assunto_codAs',
        referencedColumnName: 'codAs',
        onDelete: 'RESTRICT',
    )]
    private Collection $assuntos;

    public function __construct()
    {
        $this->autores = new ArrayCollection();
        $this->assuntos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getEditora(): string
    {
        return $this->editora;
    }

    public function setEditora(string $editora): self
    {
        $this->editora = $editora;

        return $this;
    }

    public function getEdicao(): int
    {
        return $this->edicao;
    }

    public function setEdicao(int $edicao): self
    {
        $this->edicao = $edicao;

        return $this;
    }

    public function getAnoPublicacao(): string
    {
        return $this->anoPublicacao;
    }

    public function setAnoPublicacao(string $anoPublicacao): self
    {
        $this->anoPublicacao = $anoPublicacao;

        return $this;
    }

    public function getValor(): string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * @return Collection<int, Autor>
     */
    public function getAutores(): Collection
    {
        return $this->autores;
    }

    public function addAutor(Autor $autor): self
    {
        if (!$this->autores->contains($autor)) {
            $this->autores->add($autor);
        }

        return $this;
    }

    public function removeAutor(Autor $autor): self
    {
        $this->autores->removeElement($autor);

        return $this;
    }

    /**
     * @return Collection<int, Assunto>
     */
    public function getAssuntos(): Collection
    {
        return $this->assuntos;
    }

    public function addAssunto(Assunto $assunto): self
    {
        if (!$this->assuntos->contains($assunto)) {
            $this->assuntos->add($assunto);
        }

        return $this;
    }

    public function removeAssunto(Assunto $assunto): self
    {
        $this->assuntos->removeElement($assunto);

        return $this;
    }
}