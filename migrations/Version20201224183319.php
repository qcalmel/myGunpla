<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201224183319 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filter_filter_condition (filter_id INT NOT NULL, filter_condition_id INT NOT NULL, INDEX IDX_335B4D3DD395B25E (filter_id), INDEX IDX_335B4D3D79DA7321 (filter_condition_id), PRIMARY KEY(filter_id, filter_condition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filter_filter_condition ADD CONSTRAINT FK_335B4D3DD395B25E FOREIGN KEY (filter_id) REFERENCES filter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE filter_filter_condition ADD CONSTRAINT FK_335B4D3D79DA7321 FOREIGN KEY (filter_condition_id) REFERENCES filter_condition (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE filter_filter_condition');
    }
}
