<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128162536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD image_id INT DEFAULT NULL, ADD description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C13DA5256D FOREIGN KEY (image_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_64C19C13DA5256D ON category (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C13DA5256D');
        $this->addSql('DROP INDEX IDX_64C19C13DA5256D ON category');
        $this->addSql('ALTER TABLE category DROP image_id, DROP description');
    }
}
