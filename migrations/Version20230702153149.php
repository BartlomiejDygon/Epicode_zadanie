<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230702153149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `job__offer` (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, description VARCHAR(2500) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job__application (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', job_offer_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_F585FA10A76ED395 (user_id), INDEX IDX_F585FA103481D195 (job_offer_id), PRIMARY KEY(user_id, job_offer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job__application ADD CONSTRAINT FK_F585FA10A76ED395 FOREIGN KEY (user_id) REFERENCES `user__user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job__application ADD CONSTRAINT FK_F585FA103481D195 FOREIGN KEY (job_offer_id) REFERENCES `job__offer` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job__application DROP FOREIGN KEY FK_F585FA10A76ED395');
        $this->addSql('ALTER TABLE job__application DROP FOREIGN KEY FK_F585FA103481D195');
        $this->addSql('DROP TABLE `job__offer`');
        $this->addSql('DROP TABLE job__application');
    }
}
