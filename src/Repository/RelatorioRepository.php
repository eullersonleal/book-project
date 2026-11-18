<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\DBAL\Connection;

final class RelatorioRepository
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    /**
     * @return iterable<array<string, int|string|null>>
     */
    public function listarLinhas(): iterable
    {
        return $this->connection->iterateAssociative(<<<'SQL'
            SELECT
                autor_id, autor_nome, livro_id, titulo, editora,
                edicao, ano_publicacao, valor, assunto_id, assunto_descricao
            FROM vw_relatorio_livros
            ORDER BY autor_nome, autor_id, titulo, livro_id,
                assunto_descricao, assunto_id
            SQL);
    }
}
