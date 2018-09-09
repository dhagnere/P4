<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180909133447 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF6462C4194');
        $this->addSql('DROP INDEX IDX_1F034AF6462C4194 ON billet');
        $this->addSql('ALTER TABLE billet ADD code_billet VARCHAR(255) DEFAULT NULL, ADD tarif INT NOT NULL, ADD categorie INT NOT NULL, CHANGE commande_id_id commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_1F034AF682EA2E54 ON billet (commande_id)');
        $this->addSql('ALTER TABLE commande ADD categorie INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF682EA2E54');
        $this->addSql('DROP INDEX IDX_1F034AF682EA2E54 ON billet');
        $this->addSql('ALTER TABLE billet ADD commande_id_id INT NOT NULL, DROP commande_id, DROP code_billet, DROP tarif, DROP categorie');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF6462C4194 FOREIGN KEY (commande_id_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_1F034AF6462C4194 ON billet (commande_id_id)');
        $this->addSql('ALTER TABLE commande DROP categorie');
    }
}
