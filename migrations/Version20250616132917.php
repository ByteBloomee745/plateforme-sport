<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250616132917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE classement (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, competition_id INT DEFAULT NULL, points INT NOT NULL, victoires INT NOT NULL, defaites INT NOT NULL, nuls INT NOT NULL, INDEX IDX_55EE9D6D6A99F74A (membre_id), INDEX IDX_55EE9D6D7B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, dateDebut DATE NOT NULL, format VARCHAR(255) NOT NULL, INDEX IDX_B50A2CB1AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE entrainement (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, coach_id INT DEFAULT NULL, date DATE NOT NULL, lieu VARCHAR(255) NOT NULL, INDEX IDX_A27444E56D861B89 (equipe_id), INDEX IDX_A27444E53C105691 (coach_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_2449BA15AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE match_table (id INT AUTO_INCREMENT NOT NULL, equipe_a_id INT NOT NULL, equipe_b_id INT NOT NULL, competition_id INT NOT NULL, date DATE NOT NULL, score_a INT NOT NULL, score_b INT NOT NULL, INDEX IDX_4843F0E73297C2A6 (equipe_a_id), INDEX IDX_4843F0E720226D48 (equipe_b_id), INDEX IDX_4843F0E77B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, membre_id INT NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_86FFD2856A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, nomPrenom VARCHAR(255) NOT NULL, dateNaissance DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, pointsVictoire INT DEFAULT NULL, pointsNul INT DEFAULT NULL, pointsDefaite INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE classement ADD CONSTRAINT FK_55EE9D6D7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entrainement ADD CONSTRAINT FK_A27444E56D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entrainement ADD CONSTRAINT FK_A27444E53C105691 FOREIGN KEY (coach_id) REFERENCES membre (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_table ADD CONSTRAINT FK_4843F0E73297C2A6 FOREIGN KEY (equipe_a_id) REFERENCES equipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_table ADD CONSTRAINT FK_4843F0E720226D48 FOREIGN KEY (equipe_b_id) REFERENCES equipe (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_table ADD CONSTRAINT FK_4843F0E77B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membership ADD CONSTRAINT FK_86FFD2856A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6D6A99F74A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE classement DROP FOREIGN KEY FK_55EE9D6D7B39D312
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1AC78BCF8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entrainement DROP FOREIGN KEY FK_A27444E56D861B89
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entrainement DROP FOREIGN KEY FK_A27444E53C105691
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15AC78BCF8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_table DROP FOREIGN KEY FK_4843F0E73297C2A6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_table DROP FOREIGN KEY FK_4843F0E720226D48
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_table DROP FOREIGN KEY FK_4843F0E77B39D312
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membership DROP FOREIGN KEY FK_86FFD2856A99F74A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE classement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE competition
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE entrainement
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE equipe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE match_table
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE membership
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE membre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sport
        SQL);
    }
}
