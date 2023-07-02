<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230702151627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `user__file` (id INT AUTO_INCREMENT NOT NULL, owner_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', original_name VARCHAR(255) NOT NULL, clear_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3378BD537E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user__user` (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_32745D0AE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `user__file` ADD CONSTRAINT FK_3378BD537E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user__user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user__file` DROP FOREIGN KEY FK_3378BD537E3C61F9');
        $this->addSql('DROP TABLE `user__file`');
        $this->addSql('DROP TABLE `user__user`');
    }
}
