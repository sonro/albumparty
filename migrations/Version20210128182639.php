<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128182639 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, year SMALLINT NOT NULL, image_path VARCHAR(255) NOT NULL, global_ranking SMALLINT DEFAULT NULL, wikipedia VARCHAR(255) DEFAULT NULL, spotify VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE "group" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_id INTEGER NOT NULL, party_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_6DC044C5642B8210 ON "group" (admin_id)');
        $this->addSql('CREATE INDEX IDX_6DC044C5213C1059 ON "group" (party_id)');
        $this->addSql('CREATE TABLE party (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, current_album_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, interval SMALLINT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_89954EE08C4FD1E5 ON party (current_album_id)');
        $this->addSql('CREATE TABLE party_albums_done (party_id INTEGER NOT NULL, album_id INTEGER NOT NULL, PRIMARY KEY(party_id, album_id))');
        $this->addSql('CREATE INDEX IDX_34BC699D213C1059 ON party_albums_done (party_id)');
        $this->addSql('CREATE INDEX IDX_34BC699D1137ABCF ON party_albums_done (album_id)');
        $this->addSql('CREATE TABLE party_albums_left (party_id INTEGER NOT NULL, album_id INTEGER NOT NULL, PRIMARY KEY(party_id, album_id))');
        $this->addSql('CREATE INDEX IDX_5EF66E5E213C1059 ON party_albums_left (party_id)');
        $this->addSql('CREATE INDEX IDX_5EF66E5E1137ABCF ON party_albums_left (album_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, party_id INTEGER DEFAULT NULL, user_group_id INTEGER DEFAULT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE INDEX IDX_8D93D649213C1059 ON user (party_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491ED93D47 ON user (user_group_id)');
        $this->addSql('CREATE TABLE user_album_rating (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, album_id INTEGER NOT NULL, rating SMALLINT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_8A3E6797A76ED395 ON user_album_rating (user_id)');
        $this->addSql('CREATE INDEX IDX_8A3E67971137ABCF ON user_album_rating (album_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_albums_done');
        $this->addSql('DROP TABLE party_albums_left');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_album_rating');
    }
}
