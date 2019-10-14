<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009134204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidat DROP nb_annee_experience, CHANGE mobilite_zone mobilite_zone VARCHAR(120) DEFAULT NULL, CHANGE adresse_1 adresse_1 VARCHAR(120) NOT NULL, CHANGE adresse_2 adresse_2 VARCHAR(120) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidat ADD nb_annee_experience INT DEFAULT NULL, CHANGE mobilite_zone mobilite_zone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE adresse_1 adresse_1 VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE adresse_2 adresse_2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
