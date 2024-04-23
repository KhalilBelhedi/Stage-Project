<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230910144451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devise ADD marche_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devise ADD CONSTRAINT FK_43EDA4DF9E494911 FOREIGN KEY (marche_id) REFERENCES marche (id)');
        $this->addSql('CREATE INDEX IDX_43EDA4DF9E494911 ON devise (marche_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devise DROP FOREIGN KEY FK_43EDA4DF9E494911');
        $this->addSql('DROP INDEX IDX_43EDA4DF9E494911 ON devise');
        $this->addSql('ALTER TABLE devise DROP marche_id');
    }
}
