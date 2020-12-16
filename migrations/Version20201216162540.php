<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216162540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grade_scale (grade_id INT NOT NULL, scale_id INT NOT NULL, INDEX IDX_F15F57ADFE19A1A8 (grade_id), INDEX IDX_F15F57ADF73142C2 (scale_id), PRIMARY KEY(grade_id, scale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grade_scale ADD CONSTRAINT FK_F15F57ADFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade_scale ADD CONSTRAINT FK_F15F57ADF73142C2 FOREIGN KEY (scale_id) REFERENCES scale (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE scale_grade');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scale_grade (scale_id INT NOT NULL, grade_id INT NOT NULL, INDEX IDX_41E59A37F73142C2 (scale_id), INDEX IDX_41E59A37FE19A1A8 (grade_id), PRIMARY KEY(scale_id, grade_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE scale_grade ADD CONSTRAINT FK_41E59A37F73142C2 FOREIGN KEY (scale_id) REFERENCES scale (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scale_grade ADD CONSTRAINT FK_41E59A37FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE grade_scale');
    }
}
