<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315105907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE etablissement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE etablissement (id INT NOT NULL, uai VARCHAR(255) NOT NULL, appellation_officelle VARCHAR(512) NOT NULL, denomination VARCHAR(255) NOT NULL, secteur VARCHAR(50) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, adresse VARCHAR(1024) NOT NULL, departement VARCHAR(255) NOT NULL, code_departement INT NOT NULL, commune VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, academie VARCHAR(255) NOT NULL, code_postal INT NOT NULL, date_ouverture DATE NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etablissement_id_seq CASCADE');
        $this->addSql('DROP TABLE etablissement');
    }
}
