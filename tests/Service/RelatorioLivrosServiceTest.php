<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\RelatorioLivrosService;
use PHPUnit\Framework\TestCase;

final class RelatorioLivrosServiceTest extends TestCase
{
    public function testBaseVaziaProduzRelatorioVazio(): void
    {
        $service = new RelatorioLivrosService();

        $this->assertSame([], $service->agruparPorAutor([]));
    }

    public function testAgrupaPorIdentificadorSemRepetirLivrosOuAssuntos(): void
    {
        $base = [
            'livro_id' => 10,
            'titulo' => 'Livro de teste',
            'editora' => 'Editora de teste',
            'edicao' => 1,
            'ano_publicacao' => '2026',
            'valor' => '49.90',
        ];

        $linhas = [];

        foreach ([1, 2] as $autorId) {
            foreach ([3 => 'Romance', 4 => 'Ficção'] as $assuntoId => $descricao) {
                $linhas[] = array_merge($base, [
                    'autor_id' => $autorId,
                    'autor_nome' => 'Mesmo nome',
                    'assunto_id' => $assuntoId,
                    'assunto_descricao' => $descricao,
                ]);
            }
        }

        $service = new RelatorioLivrosService();
        $grupos = $service->agruparPorAutor($linhas);

        $this->assertCount(2, $grupos);
        $this->assertArrayHasKey('autor_1', $grupos);
        $this->assertArrayHasKey('autor_2', $grupos);

        foreach ($grupos as $grupo) {
            $this->assertCount(1, $grupo['livros']);
            $this->assertSame(
                [3 => 'Romance', 4 => 'Ficção'],
                $grupo['livros'][10]['assuntos'],
            );
        }
    }

    public function testIncluiLivroSemAutorESemAssunto(): void
    {
        $linhas = [[
            'autor_id' => null,
            'autor_nome' => null,
            'livro_id' => 10,
            'titulo' => 'Livro de teste',
            'editora' => 'Editora de teste',
            'edicao' => 1,
            'ano_publicacao' => '2026',
            'valor' => '0.00',
            'assunto_id' => null,
            'assunto_descricao' => null,
        ]];

        $service = new RelatorioLivrosService();
        $grupos = $service->agruparPorAutor($linhas);

        $this->assertCount(1, $grupos);
        $this->assertNull($grupos['autor_sem_cadastro']['id']);
        $this->assertSame('Sem autor cadastrado', $grupos['autor_sem_cadastro']['nome']);
        $this->assertSame([], $grupos['autor_sem_cadastro']['livros'][10]['assuntos']);
    }
}
