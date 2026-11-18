<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Assunto;
use App\Entity\Autor;
use App\Entity\Livro;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Symfony\Component\Validator\Validation;

final class LivroTest extends TestCase
{
    public function testLivroValidoDeveSerAceito(): void
    {
        $livro = new Livro();
        $livro->setTitulo('Dom Casmurro');
        $livro->setEditora('Editora de teste');
        $livro->setEdicao(1);
        $livro->setAnoPublicacao('2026');
        $livro->setValor('49.90');

        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $this->assertCount(0, $validator->validate($livro));
    }

    #[DataProvider('valoresDosCampos')]
    public function testValidacaoDosCampos(
        string $campo,
        string|int $valor,
        int $quantidadeEsperada,
    ): void {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validator->validatePropertyValue(
            Livro::class,
            $campo,
            $valor,
        );

        $this->assertCount($quantidadeEsperada, $violations);
    }

    /**
     * @return array<string, array{string, string|int, int}>
     */
    public static function valoresDosCampos(): array
    {
        return [
            'titulo valido' => ['titulo', 'Dom Casmurro', 0],
            'titulo vazio' => ['titulo', '', 1],
            'titulo com 40 caracteres' => ['titulo', str_repeat('A', 40), 0],
            'titulo com 41 caracteres' => ['titulo', str_repeat('A', 41), 1],

            'editora valida' => ['editora', 'Editora de teste', 0],
            'editora vazia' => ['editora', '', 1],
            'editora com 40 caracteres' => ['editora', str_repeat('A', 40), 0],
            'editora com 41 caracteres' => ['editora', str_repeat('A', 41), 1],

            'edicao positiva' => ['edicao', 1, 0],
            'edicao zero' => ['edicao', 0, 1],
            'edicao negativa' => ['edicao', -1, 1],
            'edicao no limite do banco' => ['edicao', 2147483647, 0],
            'edicao acima do limite do banco' => ['edicao', 2147483648, 1],

            'ano valido' => ['anoPublicacao', '2026', 0],
            'ano vazio' => ['anoPublicacao', '', 1],
            'ano com tres digitos' => ['anoPublicacao', '202', 1],
            'ano com cinco digitos' => ['anoPublicacao', '20260', 1],
            'ano com letras' => ['anoPublicacao', '20A6', 1],

            'valor zero' => ['valor', '0.00', 0],
            'valor com uma casa decimal' => ['valor', '49.9', 0],
            'valor com duas casas decimais' => ['valor', '49.90', 0],
            'valor no limite do banco' => ['valor', '99999999.99', 0],
            'valor acima do limite do banco' => ['valor', '100000000.00', 1],
            'valor negativo' => ['valor', '-0.01', 1],
            'valor com tres casas decimais' => ['valor', '49.999', 1],
            'valor com letras' => ['valor', 'abc', 1],
            'valor vazio' => ['valor', '', 1],
        ];
    }

    public function testValorNuloDeveVirarStringVazia(): void
    {
        $livro = new Livro();
        $livro->setValor(null);

        $this->assertSame('', $livro->getValor());
    }

    public function testAssociacaoERemocaoDeAutores(): void
    {
        $livro = new Livro();
        $primeiroAutor = new Autor();
        $segundoAutor = new Autor();

        $livro->addAutor($primeiroAutor);
        $livro->addAutor($segundoAutor);
        $livro->addAutor($primeiroAutor);

        $this->assertCount(2, $livro->getAutores());
        $this->assertTrue($livro->getAutores()->contains($primeiroAutor));
        $this->assertTrue($livro->getAutores()->contains($segundoAutor));

        $livro->removeAutor($primeiroAutor);

        $this->assertCount(1, $livro->getAutores());
        $this->assertFalse($livro->getAutores()->contains($primeiroAutor));
        $this->assertTrue($livro->getAutores()->contains($segundoAutor));
    }

    public function testAssociacaoERemocaoDeAssuntos(): void
    {
        $livro = new Livro();
        $primeiroAssunto = new Assunto();
        $segundoAssunto = new Assunto();

        $livro->addAssunto($primeiroAssunto);
        $livro->addAssunto($segundoAssunto);
        $livro->addAssunto($primeiroAssunto);

        $this->assertCount(2, $livro->getAssuntos());
        $this->assertTrue($livro->getAssuntos()->contains($primeiroAssunto));
        $this->assertTrue($livro->getAssuntos()->contains($segundoAssunto));

        $livro->removeAssunto($primeiroAssunto);

        $this->assertCount(1, $livro->getAssuntos());
        $this->assertFalse($livro->getAssuntos()->contains($primeiroAssunto));
        $this->assertTrue($livro->getAssuntos()->contains($segundoAssunto));
    }

    public function testTituloDeveEstarMapeadoParaColuna(): void
    {
        $property = new ReflectionProperty(Livro::class, 'titulo');
        $attributes = $property->getAttributes(ORM\Column::class);

        $this->assertCount(1, $attributes);
        $this->assertSame('Titulo', $attributes[0]->newInstance()->name);
    }
}