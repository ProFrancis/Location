<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021161253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D57108F2A');
        $this->addSql('DROP INDEX IDX_292FFF1D57108F2A ON vehicule');
        $this->addSql('ALTER TABLE vehicule ADD titre VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE id_agence_id agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DD725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1DD725330D ON vehicule (agence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DD725330D');
        $this->addSql('DROP INDEX IDX_292FFF1DD725330D ON vehicule');
        $this->addSql('ALTER TABLE vehicule DROP titre, CHANGE description description VARCHAR(255) NOT NULL, CHANGE agence_id id_agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D57108F2A FOREIGN KEY (id_agence_id) REFERENCES agence (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_292FFF1D57108F2A ON vehicule (id_agence_id)');
    }
}
