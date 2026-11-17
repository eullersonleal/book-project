<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Autor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

final class AutorTest extends TestCase
{
    public function testValidAutor(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $autor = new Autor();
        $autor->setNome("");

        $violations = $validator->validate($autor);

        $this->assertCount(1, $violations);
        $this->assertSame('nome', $violations->get(0)->getPropertyPath());
        $this->assertSame('Informe o nome do autor.', $violations->get(0)->getMessage());
    }

    public function testNomeValidoDeveSerAceito(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $autor = new Autor();
        $autor->setNome('Machado de Assis');

        $violations = $validator->validate($autor);

        $this->assertCount(0, $violations);
    }

    public function testNomeCom40CaracteresDeveSerAceito(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $autor = new Autor();
        $autor->setNome(str_repeat('A', 40));

        $violations = $validator->validate($autor);

        $this->assertCount(0, $violations);
    }

    public function testNomeCom41CaracteresDeveSerRejeitado(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $autor = new Autor();
        $autor->setNome(str_repeat('A', 41));

        $violations = $validator->validate($autor);

        $this->assertCount(1, $violations);
        $this->assertSame('nome', $violations->get(0)->getPropertyPath());
        $this->assertSame(
            'O nome deve ter no máximo 40 caracteres.',
            $violations->get(0)->getMessage(),
        );
    }
}