<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261118175816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria a view utilizada pelo relatorio de livros';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE SQL SECURITY INVOKER VIEW vw_relatorio_livros AS
            SELECT
                autor.CodAu AS autor_id,
                autor.Nome AS autor_nome,
                livro.Codl AS livro_id,
                livro.Titulo AS titulo,
                livro.Editora AS editora,
                livro.Edicao AS edicao,
                livro.AnoPublicacao AS ano_publicacao,
                livro.Valor AS valor,
                assunto.codAs AS assunto_id,
                assunto.Descricao AS assunto_descricao
            FROM Livro livro
            LEFT JOIN Livro_Autor livro_autor
                ON livro_autor.Livro_Codl = livro.Codl
            LEFT JOIN Autor autor
                ON autor.CodAu = livro_autor.Autor_CodAu
            LEFT JOIN Livro_Assunto livro_assunto
                ON livro_assunto.Livro_Codl = livro.Codl
            LEFT JOIN Assunto assunto
                ON assunto.codAs = livro_assunto.Assunto_codAs
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP VIEW vw_relatorio_livros');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
