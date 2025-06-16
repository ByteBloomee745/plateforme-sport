<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250616150755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe ADD coach_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe ADD CONSTRAINT FK_2449BA153C105691 FOREIGN KEY (coach_id) REFERENCES membre (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2449BA153C105691 ON equipe (coach_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA153C105691
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_2449BA153C105691 ON equipe
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe DROP coach_id
        SQL);
    }
}
