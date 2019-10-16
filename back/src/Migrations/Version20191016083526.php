<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191016083526 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(120) NOT NULL, prenom VARCHAR(120) NOT NULL, telephone VARCHAR(20) NOT NULL, email VARCHAR(120) NOT NULL, civilite INT DEFAULT 0 NOT NULL, date_creation DATETIME NOT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(120) NOT NULL, poste_vise VARCHAR(120) NOT NULL, date_naissance DATETIME NOT NULL, titre VARCHAR(120) NOT NULL, mobilite TINYINT(1) DEFAULT \'0\' NOT NULL, mobilite_zone VARCHAR(120) DEFAULT NULL, adresse_1 VARCHAR(120) NOT NULL, adresse_2 VARCHAR(120) DEFAULT NULL, notes VARCHAR(4000) DEFAULT NULL, UNIQUE INDEX UNIQ_6AB5B471E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, annee VARCHAR(4) NOT NULL, diplome VARCHAR(100) NOT NULL, obtenu TINYINT(1) DEFAULT \'0\' NOT NULL, ecole VARCHAR(50) NOT NULL, ville VARCHAR(100) DEFAULT NULL, alternance TINYINT(1) DEFAULT \'0\' NOT NULL, niveau INT DEFAULT 5 NOT NULL, INDEX IDX_404021BF8D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF8D0EB82');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE user');
    }
}
