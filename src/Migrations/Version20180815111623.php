<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180815111623 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet ADD commande_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF6462C4194 FOREIGN KEY (commande_id_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_1F034AF6462C4194 ON billet (commande_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF6462C4194');
        $this->addSql('DROP INDEX IDX_1F034AF6462C4194 ON billet');
        $this->addSql('ALTER TABLE billet DROP commande_id_id');
    }
}
