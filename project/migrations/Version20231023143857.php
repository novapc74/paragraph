<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023143857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_modification (id INT AUTO_INCREMENT NOT NULL, color_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_62C007B97ADA1FB5 (color_id), INDEX IDX_62C007B94584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_modification ADD CONSTRAINT FK_62C007B97ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE product_modification ADD CONSTRAINT FK_62C007B94584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE gallery ADD product_modification_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A78EB54BA FOREIGN KEY (product_modification_id) REFERENCES product_modification (id)');
        $this->addSql('CREATE INDEX IDX_472B783A78EB54BA ON gallery (product_modification_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A78EB54BA');
        $this->addSql('ALTER TABLE product_modification DROP FOREIGN KEY FK_62C007B97ADA1FB5');
        $this->addSql('ALTER TABLE product_modification DROP FOREIGN KEY FK_62C007B94584665A');
        $this->addSql('DROP TABLE product_modification');
        $this->addSql('DROP INDEX IDX_472B783A78EB54BA ON gallery');
        $this->addSql('ALTER TABLE gallery DROP product_modification_id');
    }
}
