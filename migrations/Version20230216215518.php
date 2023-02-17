<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216215518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_vehicule_id INT DEFAULT NULL, id_agence_id INT DEFAULT NULL, date_heure_depart DATETIME NOT NULL, date_herue_fin DATETIME NOT NULL, prix_total INT NOT NULL, date_enregistrement DATETIME NOT NULL, INDEX IDX_6EEAA67D79F37AE5 (id_user_id), INDEX IDX_6EEAA67D5258F8E6 (id_vehicule_id), INDEX IDX_6EEAA67D57108F2A (id_agence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5258F8E6 FOREIGN KEY (id_vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D57108F2A FOREIGN KEY (id_agence_id) REFERENCES agence (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D79F37AE5');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5258F8E6');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D57108F2A');
        $this->addSql('DROP TABLE commande');
    }
}
