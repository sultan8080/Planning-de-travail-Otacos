<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250801134055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE branch (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(300) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, planning_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CFBDFA14A76ED395 (user_id), INDEX IDX_CFBDFA143D865311 (planning_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, branch_id INT NOT NULL, user_id INT NOT NULL, week_number INT NOT NULL, year INT NOT NULL, start_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D499BFF6DCD6CC49 (branch_id), INDEX IDX_D499BFF6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, shift_id INT DEFAULT NULL, absence_type_id INT DEFAULT NULL, is_absent TINYINT(1) NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_BA8D27EFA76ED395 (user_id), INDEX IDX_BA8D27EFBB70BC0E (shift_id), INDEX IDX_BA8D27EFCCAA91B (absence_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shift (id INT AUTO_INCREMENT NOT NULL, shift_type_id INT DEFAULT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', day VARCHAR(255) NOT NULL, start_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', end_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', INDEX IDX_A50B3B45A81DB0EA (shift_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shift_planning (shift_id INT NOT NULL, planning_id INT NOT NULL, INDEX IDX_FD2D2752BB70BC0E (shift_id), INDEX IDX_FD2D27523D865311 (planning_id), PRIMARY KEY(shift_id, planning_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shift_type (id INT AUTO_INCREMENT NOT NULL, shift_name VARCHAR(255) NOT NULL, default_start TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', default_end TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, branch_id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', telephone VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8D93D649DCD6CC49 (branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA143D865311 FOREIGN KEY (planning_id) REFERENCES planning (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6DCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning_entry ADD CONSTRAINT FK_BA8D27EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning_entry ADD CONSTRAINT FK_BA8D27EFBB70BC0E FOREIGN KEY (shift_id) REFERENCES shift (id)');
        $this->addSql('ALTER TABLE planning_entry ADD CONSTRAINT FK_BA8D27EFCCAA91B FOREIGN KEY (absence_type_id) REFERENCES absence_type (id)');
        $this->addSql('ALTER TABLE shift ADD CONSTRAINT FK_A50B3B45A81DB0EA FOREIGN KEY (shift_type_id) REFERENCES shift_type (id)');
        $this->addSql('ALTER TABLE shift_planning ADD CONSTRAINT FK_FD2D2752BB70BC0E FOREIGN KEY (shift_id) REFERENCES shift (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shift_planning ADD CONSTRAINT FK_FD2D27523D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14A76ED395');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA143D865311');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6DCD6CC49');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6A76ED395');
        $this->addSql('ALTER TABLE planning_entry DROP FOREIGN KEY FK_BA8D27EFA76ED395');
        $this->addSql('ALTER TABLE planning_entry DROP FOREIGN KEY FK_BA8D27EFBB70BC0E');
        $this->addSql('ALTER TABLE planning_entry DROP FOREIGN KEY FK_BA8D27EFCCAA91B');
        $this->addSql('ALTER TABLE shift DROP FOREIGN KEY FK_A50B3B45A81DB0EA');
        $this->addSql('ALTER TABLE shift_planning DROP FOREIGN KEY FK_FD2D2752BB70BC0E');
        $this->addSql('ALTER TABLE shift_planning DROP FOREIGN KEY FK_FD2D27523D865311');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DCD6CC49');
        $this->addSql('DROP TABLE absence_type');
        $this->addSql('DROP TABLE branch');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE planning_entry');
        $this->addSql('DROP TABLE shift');
        $this->addSql('DROP TABLE shift_planning');
        $this->addSql('DROP TABLE shift_type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
