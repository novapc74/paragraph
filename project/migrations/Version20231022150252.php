<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022150252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_store (product_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_5E0B232B4584665A (product_id), INDEX IDX_5E0B232BB092A811 (store_id), PRIMARY KEY(product_id, store_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_store ADD CONSTRAINT FK_5E0B232B4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_store ADD CONSTRAINT FK_5E0B232BB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_472B783A4584665A ON gallery (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A4584665A');
        $this->addSql('ALTER TABLE product_store DROP FOREIGN KEY FK_5E0B232B4584665A');
        $this->addSql('ALTER TABLE product_store DROP FOREIGN KEY FK_5E0B232BB092A811');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_store');
        $this->addSql('DROP INDEX IDX_472B783A4584665A ON gallery');
        $this->addSql('ALTER TABLE gallery DROP product_id');
    }
}
