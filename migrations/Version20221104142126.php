<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221104142126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_entry (id INT AUTO_INCREMENT NOT NULL, client_order_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, price INT NOT NULL, vat DOUBLE PRECISION NOT NULL, short_description VARCHAR(255) NOT NULL, INDEX IDX_A8BFE98DA3795DFD (client_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_entry ADD CONSTRAINT FK_A8BFE98DA3795DFD FOREIGN KEY (client_order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_entry DROP FOREIGN KEY FK_A8BFE98DA3795DFD');
        $this->addSql('DROP TABLE order_entry');
    }
}
