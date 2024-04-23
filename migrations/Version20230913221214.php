<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913221214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marge (id INT AUTO_INCREMENT NOT NULL, cours_id INT NOT NULL, marge_achat DOUBLE PRECISION NOT NULL, marge_vente DOUBLE PRECISION NOT NULL, date_mise_jour DATETIME NOT NULL, UNIQUE INDEX UNIQ_640B000E7ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marge ADD CONSTRAINT FK_640B000E7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE cours ADD cours_bct_achat DOUBLE PRECISION NOT NULL, ADD cours_bct_vente DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marge DROP FOREIGN KEY FK_640B000E7ECF78B0');
        $this->addSql('DROP TABLE marge');
        $this->addSql('ALTER TABLE cours DROP cours_bct_achat, DROP cours_bct_vente');
    }
}
