<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030123642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783A78EB54BA');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product_modification DROP FOREIGN KEY FK_62C007B97ADA1FB5');
        $this->addSql('ALTER TABLE product_modification DROP FOREIGN KEY FK_62C007B94584665A');
        $this->addSql('DROP TABLE product_modification');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_472B783A78EB54BA ON gallery');
        $this->addSql('ALTER TABLE gallery DROP product_modification_id');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product ADD color_id INT DEFAULT NULL, ADD sku VARCHAR(255) NOT NULL, CHANGE category_id parent_product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2C7E20A FOREIGN KEY (parent_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD2C7E20A ON product (parent_product_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7ADA1FB5 ON product (color_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_modification (id INT AUTO_INCREMENT NOT NULL, color_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_62C007B94584665A (product_id), INDEX IDX_62C007B97ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_modification ADD CONSTRAINT FK_62C007B97ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('ALTER TABLE product_modification ADD CONSTRAINT FK_62C007B94584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE gallery ADD product_modification_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783A78EB54BA FOREIGN KEY (product_modification_id) REFERENCES product_modification (id)');
        $this->addSql('CREATE INDEX IDX_472B783A78EB54BA ON gallery (product_modification_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2C7E20A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7ADA1FB5');
        $this->addSql('DROP INDEX IDX_D34A04AD2C7E20A ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD7ADA1FB5 ON product');
        $this->addSql('ALTER TABLE product ADD category_id INT DEFAULT NULL, DROP parent_product_id, DROP color_id, DROP sku');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }
}
