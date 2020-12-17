<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217153836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34F98F144A');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334F98F144A');
        $this->addSql('CREATE TABLE model_picture (model_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_764826787975B7E7 (model_id), INDEX IDX_76482678EE45BDBF (picture_id), PRIMARY KEY(model_id, picture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE model_picture ADD CONSTRAINT FK_764826787975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_picture ADD CONSTRAINT FK_76482678EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP INDEX UNIQ_595AAE34F98F144A ON grade');
        $this->addSql('ALTER TABLE grade DROP logo_id');
        $this->addSql('DROP INDEX UNIQ_AA3A9334F98F144A ON serie');
        $this->addSql('ALTER TABLE serie DROP logo_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, unit_id INT DEFAULT NULL, model_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_C53D045FF8BD700D (unit_id), INDEX IDX_C53D045F7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('DROP TABLE model_picture');
        $this->addSql('ALTER TABLE grade ADD logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34F98F144A FOREIGN KEY (logo_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_595AAE34F98F144A ON grade (logo_id)');
        $this->addSql('ALTER TABLE serie ADD logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334F98F144A FOREIGN KEY (logo_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA3A9334F98F144A ON serie (logo_id)');
    }
}
