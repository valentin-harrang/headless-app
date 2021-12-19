<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215220713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feed (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE feed_category (id INT NOT NULL, feed_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_26998E6651A5BC03 ON feed_category (feed_id)');
        $this->addSql('CREATE TABLE news (id INT NOT NULL, feed_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, publication_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1DD3995051A5BC03 ON news (feed_id)');
        $this->addSql('ALTER TABLE feed_category ADD CONSTRAINT FK_26998E6651A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995051A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE feed_category DROP CONSTRAINT FK_26998E6651A5BC03');
        $this->addSql('ALTER TABLE news DROP CONSTRAINT FK_1DD3995051A5BC03');
        $this->addSql('DROP TABLE feed');
        $this->addSql('DROP TABLE feed_category');
        $this->addSql('DROP TABLE news');
    }
}
