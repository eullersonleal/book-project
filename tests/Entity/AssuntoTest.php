<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Assunto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

final class AssuntoTest extends TestCase
{
    public function testDescricaoVaziaDeveSerRejeitada(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $assunto = new Assunto();
        $assunto->setDescricao('');

        $violations = $validator->validate($assunto);

        $this->assertCount(1, $violations);
        $this->assertSame('descricao', $violations->get(0)->getPropertyPath());
        $this->assertSame(
            'Informe a descrição do assunto.',
            $violations->get(0)->getMessage(),
        );
    }

    public function testDescricaoValidaDeveSerAceita(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $assunto = new Assunto();
        $assunto->setDescricao('Literatura');

        $violations = $validator->validate($assunto);

        $this->assertCount(0, $violations);
    }

    public function testDescricaoCom20CaracteresDeveSerAceita(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $assunto = new Assunto();
        $assunto->setDescricao(str_repeat('A', 20));

        $violations = $validator->validate($assunto);

        $this->assertCount(0, $violations);
    }

    public function testDescricaoCom21CaracteresDeveSerRejeitada(): void
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $assunto = new Assunto();
        $assunto->setDescricao(str_repeat('A', 21));

        $violations = $validator->validate($assunto);

        $this->assertCount(1, $violations);
        $this->assertSame('descricao', $violations->get(0)->getPropertyPath());
        $this->assertSame(
            'A descrição deve ter no máximo 20 caracteres.',
            $violations->get(0)->getMessage(),
        );
    }
}