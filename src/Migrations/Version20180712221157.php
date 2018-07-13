<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180712221157 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE ftp_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ftp_history (id INT NOT NULL, user_id_id INT NOT NULL, client_ip VARCHAR(255) DEFAULT NULL, server_ip VARCHAR(255) DEFAULT NULL, command VARCHAR(255) DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EA3745FF9D86650F ON ftp_history (user_id_id)');
        $this->addSql('ALTER TABLE ftp_history ADD CONSTRAINT FK_EA3745FF9D86650F FOREIGN KEY (user_id_id) REFERENCES ftp_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ftp_user ADD active BOOLEAN DEFAULT \'true\' NOT NULL');
        $this->addSql('ALTER TABLE ftp_group ADD active BOOLEAN DEFAULT \'true\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE ftp_history_id_seq CASCADE');
        $this->addSql('DROP TABLE ftp_history');
        $this->addSql('ALTER TABLE ftp_group DROP active');
        $this->addSql('ALTER TABLE ftp_user DROP active');
    }
}
