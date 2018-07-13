<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180713101903 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE ftp_history DROP CONSTRAINT fk_ea3745ffa76ed395');
        $this->addSql('DROP INDEX idx_ea3745ffa76ed395');
        $this->addSql('ALTER TABLE ftp_history RENAME COLUMN user_id TO ftpuser_id');
        $this->addSql('ALTER TABLE ftp_history ADD CONSTRAINT FK_EA3745FF46E13E3 FOREIGN KEY (ftpuser_id) REFERENCES ftp_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EA3745FF46E13E3 ON ftp_history (ftpuser_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ftp_history DROP CONSTRAINT FK_EA3745FF46E13E3');
        $this->addSql('DROP INDEX IDX_EA3745FF46E13E3');
        $this->addSql('ALTER TABLE ftp_history RENAME COLUMN ftpuser_id TO user_id');
        $this->addSql('ALTER TABLE ftp_history ADD CONSTRAINT fk_ea3745ffa76ed395 FOREIGN KEY (user_id) REFERENCES ftp_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ea3745ffa76ed395 ON ftp_history (user_id)');
    }
}
