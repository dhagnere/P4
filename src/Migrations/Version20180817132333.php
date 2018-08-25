<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180817132333 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE billet (id INT AUTO_INCREMENT NOT NULL, commande_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL, country VARCHAR(255) NOT NULL, discount TINYINT(1) DEFAULT NULL, INDEX IDX_1F034AF6462C4194 (commande_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(255) NOT NULL, date_visit DATETIME NOT NULL, nb_tickets INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billet ADD CONSTRAINT FK_1F034AF6462C4194 FOREIGN KEY (commande_id_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE billet DROP FOREIGN KEY FK_1F034AF6462C4194');
        $this->addSql('DROP TABLE billet');
        $this->addSql('DROP TABLE commande');
    }
}
