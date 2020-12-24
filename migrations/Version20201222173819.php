<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201222173819 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie ADD main_serie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A93346199C8 FOREIGN KEY (main_serie_id) REFERENCES serie (id)');
        $this->addSql('CREATE INDEX IDX_AA3A93346199C8 ON serie (main_serie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A93346199C8');
        $this->addSql('DROP INDEX IDX_AA3A93346199C8 ON serie');
        $this->addSql('ALTER TABLE serie DROP main_serie_id');
    }
}
