<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241113044931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F5258F8E6');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, modele_id INT NOT NULL, immatriculation VARCHAR(20) NOT NULL, date_mise_en_circulation DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, date_rentree DATETIME NOT NULL, chevaux_fiscaux INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_292FFF1DAC14B70A (modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E664827B9B2');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66AC14B70A');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP INDEX IDX_C53D045F5258F8E6 ON image');
        $this->addSql('ALTER TABLE image ADD vehicule_id INT NOT NULL, DROP id_vehicule_id, DROP id_image');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F4A4A3511 ON image (vehicule_id)');
        $this->addSql('ALTER TABLE marque DROP id_marque, CHANGE nom_marque nom_marque VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_10028558C8120595');
        $this->addSql('DROP INDEX IDX_10028558C8120595 ON modele');
        $this->addSql('ALTER TABLE modele ADD marque_id INT NOT NULL, DROP id_marque_id, DROP id_modele, CHANGE nom_modele nom_modele VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_100285584827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_100285584827B9B2 ON modele (marque_id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE prenom prenom VARCHAR(50) NOT NULL, CHANGE username username VARCHAR(50) NOT NULL, CHANGE email email VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4A4A3511');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, modele_id INT NOT NULL, marque_id INT DEFAULT NULL, id_vehicule INT NOT NULL, id_modele INT NOT NULL, immatriculation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_mise_en_circulation DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, date_rentree DATETIME NOT NULL, chevaux_fiscaux INT NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_23A0E664827B9B2 (marque_id), INDEX IDX_23A0E66AC14B70A (modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E664827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66AC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DAC14B70A');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_100285584827B9B2');
        $this->addSql('DROP INDEX IDX_100285584827B9B2 ON modele');
        $this->addSql('ALTER TABLE modele ADD id_modele INT NOT NULL, CHANGE nom_modele nom_modele VARCHAR(255) NOT NULL, CHANGE marque_id id_marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_10028558C8120595 FOREIGN KEY (id_marque_id) REFERENCES marque (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_10028558C8120595 ON modele (id_marque_id)');
        $this->addSql('ALTER TABLE marque ADD id_marque INT NOT NULL, CHANGE nom_marque nom_marque VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX IDX_C53D045F4A4A3511 ON image');
        $this->addSql('ALTER TABLE image ADD id_image INT NOT NULL, CHANGE vehicule_id id_vehicule_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F5258F8E6 FOREIGN KEY (id_vehicule_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C53D045F5258F8E6 ON image (id_vehicule_id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE username username VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
    }
}
