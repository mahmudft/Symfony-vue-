<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330231244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE favourites_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fruit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE favourites (id INT NOT NULL, fruit_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7F07C501BAC115F0 ON favourites (fruit_id)');
        $this->addSql('CREATE TABLE fruit (id INT NOT NULL, name VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, genus VARCHAR(255) NOT NULL, orderd VARCHAR(255) NOT NULL, nutritions JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE favourites ADD CONSTRAINT FK_7F07C501BAC115F0 FOREIGN KEY (fruit_id) REFERENCES fruit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE favourites_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fruit_id_seq CASCADE');
        $this->addSql('ALTER TABLE favourites DROP CONSTRAINT FK_7F07C501BAC115F0');
        $this->addSql('DROP TABLE favourites');
        $this->addSql('DROP TABLE fruit');
    }
}
