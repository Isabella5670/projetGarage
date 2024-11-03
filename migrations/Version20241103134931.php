<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241103134931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD nom_marque_id INT NOT NULL, ADD nom_modele_id INT DEFAULT NULL, ADD id_vehicule INT NOT NULL, ADD id_modele INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DCD6C8F3 FOREIGN KEY (nom_marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6638E5C64B FOREIGN KEY (nom_modele_id) REFERENCES modele (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66DCD6C8F3 ON article (nom_marque_id)');
        $this->addSql('CREATE INDEX IDX_23A0E6638E5C64B ON article (nom_modele_id)');
        $this->addSql('ALTER TABLE image ADD id_image INT NOT NULL');
        $this->addSql('ALTER TABLE marque ADD id_marque INT NOT NULL');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_10028558C8120595');
        $this->addSql('DROP INDEX IDX_10028558C8120595 ON modele');
        $this->addSql('ALTER TABLE modele ADD id_modele INT NOT NULL, CHANGE id_marque id_marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_10028558C8120595 FOREIGN KEY (id_marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_10028558C8120595 ON modele (id_marque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66DCD6C8F3');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6638E5C64B');
        $this->addSql('DROP INDEX IDX_23A0E66DCD6C8F3 ON article');
        $this->addSql('DROP INDEX IDX_23A0E6638E5C64B ON article');
        $this->addSql('ALTER TABLE article DROP nom_marque_id, DROP nom_modele_id, DROP id_vehicule, DROP id_modele');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_10028558C8120595');
        $this->addSql('DROP INDEX IDX_10028558C8120595 ON modele');
        $this->addSql('ALTER TABLE modele ADD id_marque INT NOT NULL, DROP id_marque_id, DROP id_modele');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_10028558C8120595 FOREIGN KEY (id_marque) REFERENCES marque (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_10028558C8120595 ON modele (id_marque)');
        $this->addSql('ALTER TABLE marque DROP id_marque');
        $this->addSql('ALTER TABLE image DROP id_image');
    }
}
