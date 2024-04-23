<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911212048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours ADD devise_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CF4445056 FOREIGN KEY (devise_id) REFERENCES devise (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDCA8C9CF4445056 ON cours (devise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CF4445056');
        $this->addSql('DROP INDEX UNIQ_FDCA8C9CF4445056 ON cours');
        $this->addSql('ALTER TABLE cours DROP devise_id');
    }
}
