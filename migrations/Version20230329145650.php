<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329145650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet_ac (id INT AUTO_INCREMENT NOT NULL, label_id INT NOT NULL, projet_id INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, note SMALLINT DEFAULT NULL, INDEX IDX_567C9DD933B92F39 (label_id), INDEX IDX_567C9DD9C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet_ac ADD CONSTRAINT FK_567C9DD933B92F39 FOREIGN KEY (label_id) REFERENCES ac (id)');
        $this->addSql('ALTER TABLE projet_ac ADD CONSTRAINT FK_567C9DD9C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_ac DROP FOREIGN KEY FK_567C9DD933B92F39');
        $this->addSql('ALTER TABLE projet_ac DROP FOREIGN KEY FK_567C9DD9C18272');
        $this->addSql('DROP TABLE projet_ac');
    }
}
