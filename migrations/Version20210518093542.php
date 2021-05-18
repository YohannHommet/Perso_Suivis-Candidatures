<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518093542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applications (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, localisation_entreprise VARCHAR(255) NOT NULL, poste_recherche VARCHAR(255) NOT NULL, nature_candidature VARCHAR(255) NOT NULL, date_candidature DATETIME NOT NULL, lien_candidature VARCHAR(255) NOT NULL, email_contact VARCHAR(255) DEFAULT NULL, technos VARCHAR(255) NOT NULL, remarques VARCHAR(255) DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE applications');
    }
}
