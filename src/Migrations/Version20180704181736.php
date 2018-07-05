<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180704181736 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE ftpuser DROP CONSTRAINT fk_b0bc00ecfe54d947');
        $this->addSql('DROP SEQUENCE ftpgroup_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ftpuser_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ftp_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ftp_group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ftp_user (id INT NOT NULL, ftpgroup_id INT NOT NULL, username VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, uid INT NOT NULL, home VARCHAR(255) NOT NULL, shell VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7637DEE347910D8E ON ftp_user (ftpgroup_id)');
        $this->addSql('CREATE TABLE ftp_group (id INT NOT NULL, groupname VARCHAR(255) NOT NULL, gid INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE ftp_user ADD CONSTRAINT FK_7637DEE347910D8E FOREIGN KEY (ftpgroup_id) REFERENCES ftp_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE ftpgroup');
        $this->addSql('DROP TABLE ftpuser');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ftp_user DROP CONSTRAINT FK_7637DEE347910D8E');
        $this->addSql('DROP SEQUENCE ftp_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ftp_group_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ftpgroup_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ftpuser_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ftpgroup (id INT NOT NULL, groupname VARCHAR(255) NOT NULL, gid INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_cb413c7490da8f85 ON ftpgroup (groupname)');
        $this->addSql('CREATE UNIQUE INDEX uniq_cb413c744c397118 ON ftpgroup (gid)');
        $this->addSql('CREATE TABLE ftpuser (id INT NOT NULL, group_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, uid INT NOT NULL, home VARCHAR(255) NOT NULL, shell VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_b0bc00ecfe54d947 ON ftpuser (group_id)');
        $this->addSql('ALTER TABLE ftpuser ADD CONSTRAINT fk_b0bc00ecfe54d947 FOREIGN KEY (group_id) REFERENCES ftpgroup (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE ftp_user');
        $this->addSql('DROP TABLE ftp_group');
    }
}
