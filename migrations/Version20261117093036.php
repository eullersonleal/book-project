<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261117093036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrige os nomes da tabela Autor e da coluna CodAu';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE autor RENAME COLUMN codAu TO CodAu, RENAME TO Autor'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE Autor RENAME COLUMN CodAu TO codAu, RENAME TO autor'
        );
    }

    public function isTransactional(): bool
    {
        return false;
    }
}