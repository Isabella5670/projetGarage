<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116104506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture ADD modele_id INT NOT NULL, ADD marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FAC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810FAC14B70A ON voiture (modele_id)');
        $this->addSql('CREATE INDEX IDX_E9E2810F4827B9B2 ON voiture (marque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FAC14B70A');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F4827B9B2');
        $this->addSql('DROP INDEX IDX_E9E2810FAC14B70A ON voiture');
        $this->addSql('DROP INDEX IDX_E9E2810F4827B9B2 ON voiture');
        $this->addSql('ALTER TABLE voiture DROP modele_id, DROP marque_id');
    }
}
