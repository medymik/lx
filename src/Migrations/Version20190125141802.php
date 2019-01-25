<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190125141802 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE micro_paiement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appelle ADD micropaiment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE appelle ADD CONSTRAINT FK_FBF8F12868FE7582 FOREIGN KEY (micropaiment_id) REFERENCES micro_paiement (id)');
        $this->addSql('CREATE INDEX IDX_FBF8F12868FE7582 ON appelle (micropaiment_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appelle DROP FOREIGN KEY FK_FBF8F12868FE7582');
        $this->addSql('DROP TABLE micro_paiement');
        $this->addSql('DROP INDEX IDX_FBF8F12868FE7582 ON appelle');
        $this->addSql('ALTER TABLE appelle DROP micropaiment_id');
    }
}
