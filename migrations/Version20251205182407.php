<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251205182407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE brands RENAME INDEX slug TO UNIQ_7EA24434989D9B62');
        $this->addSql('ALTER TABLE categories RENAME INDEX slug TO UNIQ_3AF34668989D9B62');
        $this->addSql('ALTER TABLE models CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE models RENAME INDEX slug TO UNIQ_E4D63009989D9B62');
        $this->addSql('ALTER TABLE models RENAME INDEX category_id TO IDX_E4D6300912469DE2');
        $this->addSql('ALTER TABLE models RENAME INDEX brand_id TO IDX_E4D6300944F5D008');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE brands RENAME INDEX uniq_7ea24434989d9b62 TO slug');
        $this->addSql('ALTER TABLE categories RENAME INDEX uniq_3af34668989d9b62 TO slug');
        $this->addSql('ALTER TABLE models CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE models RENAME INDEX idx_e4d6300944f5d008 TO brand_id');
        $this->addSql('ALTER TABLE models RENAME INDEX idx_e4d6300912469de2 TO category_id');
        $this->addSql('ALTER TABLE models RENAME INDEX uniq_e4d63009989d9b62 TO slug');
    }
}
