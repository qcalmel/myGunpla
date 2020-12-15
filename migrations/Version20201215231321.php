<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215231321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(60) NOT NULL, name_short VARCHAR(10) DEFAULT NULL, UNIQUE INDEX UNIQ_595AAE34F98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, unit_id INT DEFAULT NULL, model_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045FF8BD700D (unit_id), INDEX IDX_C53D045F7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, grade_id INT NOT NULL, name VARCHAR(255) NOT NULL, version VARCHAR(20) DEFAULT NULL, date DATE DEFAULT NULL, price NUMERIC(10, 0) DEFAULT NULL, nb_part INT DEFAULT NULL, grade_number VARCHAR(10) DEFAULT NULL, code_jan INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_D79572D9FE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model_unit (model_id INT NOT NULL, unit_id INT NOT NULL, INDEX IDX_F1EC20B47975B7E7 (model_id), INDEX IDX_F1EC20B4F8BD700D (unit_id), PRIMARY KEY(model_id, unit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model_primaryColor (model_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_FAF3E4547975B7E7 (model_id), INDEX IDX_FAF3E4547ADA1FB5 (color_id), PRIMARY KEY(model_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model_secondaryColor (model_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_6C74D69B7975B7E7 (model_id), INDEX IDX_6C74D69B7ADA1FB5 (color_id), PRIMARY KEY(model_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model_tag (model_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_564ADD7C7975B7E7 (model_id), INDEX IDX_564ADD7CBAD26311 (tag_id), PRIMARY KEY(model_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scale (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scale_grade (scale_id INT NOT NULL, grade_id INT NOT NULL, INDEX IDX_41E59A37F73142C2 (scale_id), INDEX IDX_41E59A37FE19A1A8 (grade_id), PRIMARY KEY(scale_id, grade_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, name_short VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_AA3A9334F98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_389B78312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit_serie (unit_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_2108ED3FF8BD700D (unit_id), INDEX IDX_2108ED3FD94388BD (serie_id), PRIMARY KEY(unit_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34F98F144A FOREIGN KEY (logo_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D9FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE model_unit ADD CONSTRAINT FK_F1EC20B47975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_unit ADD CONSTRAINT FK_F1EC20B4F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_primaryColor ADD CONSTRAINT FK_FAF3E4547975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_primaryColor ADD CONSTRAINT FK_FAF3E4547ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_secondaryColor ADD CONSTRAINT FK_6C74D69B7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_secondaryColor ADD CONSTRAINT FK_6C74D69B7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_tag ADD CONSTRAINT FK_564ADD7C7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model_tag ADD CONSTRAINT FK_564ADD7CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scale_grade ADD CONSTRAINT FK_41E59A37F73142C2 FOREIGN KEY (scale_id) REFERENCES scale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scale_grade ADD CONSTRAINT FK_41E59A37FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334F98F144A FOREIGN KEY (logo_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B78312469DE2 FOREIGN KEY (category_id) REFERENCES category_tag (id)');
        $this->addSql('ALTER TABLE unit_serie ADD CONSTRAINT FK_2108ED3FF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE unit_serie ADD CONSTRAINT FK_2108ED3FD94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B78312469DE2');
        $this->addSql('ALTER TABLE model_primaryColor DROP FOREIGN KEY FK_FAF3E4547ADA1FB5');
        $this->addSql('ALTER TABLE model_secondaryColor DROP FOREIGN KEY FK_6C74D69B7ADA1FB5');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D9FE19A1A8');
        $this->addSql('ALTER TABLE scale_grade DROP FOREIGN KEY FK_41E59A37FE19A1A8');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34F98F144A');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334F98F144A');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F7975B7E7');
        $this->addSql('ALTER TABLE model_unit DROP FOREIGN KEY FK_F1EC20B47975B7E7');
        $this->addSql('ALTER TABLE model_primaryColor DROP FOREIGN KEY FK_FAF3E4547975B7E7');
        $this->addSql('ALTER TABLE model_secondaryColor DROP FOREIGN KEY FK_6C74D69B7975B7E7');
        $this->addSql('ALTER TABLE model_tag DROP FOREIGN KEY FK_564ADD7C7975B7E7');
        $this->addSql('ALTER TABLE scale_grade DROP FOREIGN KEY FK_41E59A37F73142C2');
        $this->addSql('ALTER TABLE unit_serie DROP FOREIGN KEY FK_2108ED3FD94388BD');
        $this->addSql('ALTER TABLE model_tag DROP FOREIGN KEY FK_564ADD7CBAD26311');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF8BD700D');
        $this->addSql('ALTER TABLE model_unit DROP FOREIGN KEY FK_F1EC20B4F8BD700D');
        $this->addSql('ALTER TABLE unit_serie DROP FOREIGN KEY FK_2108ED3FF8BD700D');
        $this->addSql('DROP TABLE category_tag');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE model_unit');
        $this->addSql('DROP TABLE model_primaryColor');
        $this->addSql('DROP TABLE model_secondaryColor');
        $this->addSql('DROP TABLE model_tag');
        $this->addSql('DROP TABLE scale');
        $this->addSql('DROP TABLE scale_grade');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE unit_serie');
    }
}
