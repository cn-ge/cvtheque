<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017154645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, candidat_id INT NOT NULL, annee VARCHAR(4) NOT NULL, diplome VARCHAR(100) NOT NULL, obtenu TINYINT(1) DEFAULT \'0\' NOT NULL, ecole VARCHAR(50) NOT NULL, ville VARCHAR(100) DEFAULT NULL, alternance TINYINT(1) DEFAULT \'0\' NOT NULL, niveau INT DEFAULT 5 NOT NULL, INDEX IDX_404021BF8D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, is_active TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', civilite INT DEFAULT 0 NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, adresse_1 VARCHAR(120) DEFAULT NULL, adresse_2 VARCHAR(120) DEFAULT NULL, cp VARCHAR(5) DEFAULT NULL, ville VARCHAR(120) DEFAULT NULL, poste_recherche VARCHAR(120) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, statut VARCHAR(120) DEFAULT NULL, mobilite TINYINT(1) DEFAULT \'0\', mobilite_zone VARCHAR(120) DEFAULT NULL, notes VARCHAR(4000) DEFAULT NULL, date_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF8D0EB82 FOREIGN KEY (candidat_id) REFERENCES user (id)');
        $now = date_format(new \DateTime(), 'y-m-d h:i:s');
        $admin = "admin@admin.fr";
        $hr = "hr@hr.fr";
        $password = "$2y$12\$dZgvwdD9o9f6KcnkEQhBJeAUPbB3X/YmPLfcNQUbLDvCPv1NvFU9.";
        $role_admin="a:1:{i:0;s:10:'ROLE_ADMIN';}";
        $role_hr="a:1:{i:0;s:7:'ROLE_HR';}";
        $this->addSql('INSERT INTO user (email, password, is_active, roles, date_creation) VALUES ("' . $admin . '", "' . $password . '", 1, "'. $role_admin . '", "' . $now . '")');
        $this->addSql('INSERT INTO user (email, password, is_active, roles, date_creation) VALUES ("' . $hr . '", "' . $password . '", 1, "'. $role_hr . '", "' . $now . '")');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF8D0EB82');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE user');
    }
}
