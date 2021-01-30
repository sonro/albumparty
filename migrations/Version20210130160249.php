<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210130160249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__album AS SELECT id, title, artist, year, image_path, global_ranking, wikipedia, spotify, youtube FROM album');
        $this->addSql('DROP TABLE album');
        $this->addSql('CREATE TABLE album (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, artist VARCHAR(255) NOT NULL COLLATE BINARY, year SMALLINT NOT NULL, image_path VARCHAR(255) NOT NULL COLLATE BINARY, wikipedia VARCHAR(255) DEFAULT NULL COLLATE BINARY, spotify VARCHAR(255) DEFAULT NULL COLLATE BINARY, youtube VARCHAR(255) DEFAULT NULL COLLATE BINARY, global_rating SMALLINT DEFAULT NULL)');
        $this->addSql('INSERT INTO album (id, title, artist, year, image_path, global_rating, wikipedia, spotify, youtube) SELECT id, title, artist, year, image_path, global_ranking, wikipedia, spotify, youtube FROM __temp__album');
        $this->addSql('DROP TABLE __temp__album');
        $this->addSql('DROP INDEX IDX_6DC044C5213C1059');
        $this->addSql('DROP INDEX IDX_6DC044C5642B8210');
        $this->addSql('CREATE TEMPORARY TABLE __temp__group AS SELECT id, admin_id, party_id, name FROM "group"');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('CREATE TABLE "group" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_id INTEGER NOT NULL, party_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_6DC044C5642B8210 FOREIGN KEY (admin_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6DC044C5213C1059 FOREIGN KEY (party_id) REFERENCES party (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "group" (id, admin_id, party_id, name) SELECT id, admin_id, party_id, name FROM __temp__group');
        $this->addSql('DROP TABLE __temp__group');
        $this->addSql('CREATE INDEX IDX_6DC044C5213C1059 ON "group" (party_id)');
        $this->addSql('CREATE INDEX IDX_6DC044C5642B8210 ON "group" (admin_id)');
        $this->addSql('DROP INDEX IDX_89954EE08C4FD1E5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__party AS SELECT id, current_album_id, name, interval FROM party');
        $this->addSql('DROP TABLE party');
        $this->addSql('CREATE TABLE party (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, current_album_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, interval SMALLINT NOT NULL, days_till_interval SMALLINT NOT NULL, CONSTRAINT FK_89954EE08C4FD1E5 FOREIGN KEY (current_album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO party (id, current_album_id, name, interval) SELECT id, current_album_id, name, interval FROM __temp__party');
        $this->addSql('DROP TABLE __temp__party');
        $this->addSql('CREATE INDEX IDX_89954EE08C4FD1E5 ON party (current_album_id)');
        $this->addSql('DROP INDEX IDX_34BC699D1137ABCF');
        $this->addSql('DROP INDEX IDX_34BC699D213C1059');
        $this->addSql('CREATE TEMPORARY TABLE __temp__party_albums_done AS SELECT party_id, album_id FROM party_albums_done');
        $this->addSql('DROP TABLE party_albums_done');
        $this->addSql('CREATE TABLE party_albums_done (party_id INTEGER NOT NULL, album_id INTEGER NOT NULL, PRIMARY KEY(party_id, album_id), CONSTRAINT FK_34BC699D213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_34BC699D1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO party_albums_done (party_id, album_id) SELECT party_id, album_id FROM __temp__party_albums_done');
        $this->addSql('DROP TABLE __temp__party_albums_done');
        $this->addSql('CREATE INDEX IDX_34BC699D1137ABCF ON party_albums_done (album_id)');
        $this->addSql('CREATE INDEX IDX_34BC699D213C1059 ON party_albums_done (party_id)');
        $this->addSql('DROP INDEX IDX_5EF66E5E1137ABCF');
        $this->addSql('DROP INDEX IDX_5EF66E5E213C1059');
        $this->addSql('CREATE TEMPORARY TABLE __temp__party_albums_left AS SELECT party_id, album_id FROM party_albums_left');
        $this->addSql('DROP TABLE party_albums_left');
        $this->addSql('CREATE TABLE party_albums_left (party_id INTEGER NOT NULL, album_id INTEGER NOT NULL, PRIMARY KEY(party_id, album_id), CONSTRAINT FK_5EF66E5E213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5EF66E5E1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO party_albums_left (party_id, album_id) SELECT party_id, album_id FROM __temp__party_albums_left');
        $this->addSql('DROP TABLE __temp__party_albums_left');
        $this->addSql('CREATE INDEX IDX_5EF66E5E1137ABCF ON party_albums_left (album_id)');
        $this->addSql('CREATE INDEX IDX_5EF66E5E213C1059 ON party_albums_left (party_id)');
        $this->addSql('DROP INDEX IDX_8D93D6491ED93D47');
        $this->addSql('DROP INDEX IDX_8D93D649213C1059');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, party_id, user_group_id, username, roles, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, party_id INTEGER DEFAULT NULL, user_group_id INTEGER DEFAULT NULL, username VARCHAR(180) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , password VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_8D93D649213C1059 FOREIGN KEY (party_id) REFERENCES party (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D6491ED93D47 FOREIGN KEY (user_group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, party_id, user_group_id, username, roles, password) SELECT id, party_id, user_group_id, username, roles, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D6491ED93D47 ON user (user_group_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649213C1059 ON user (party_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('DROP INDEX IDX_8A3E67971137ABCF');
        $this->addSql('DROP INDEX IDX_8A3E6797A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_album_rating AS SELECT id, user_id, album_id, rating FROM user_album_rating');
        $this->addSql('DROP TABLE user_album_rating');
        $this->addSql('CREATE TABLE user_album_rating (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, album_id INTEGER NOT NULL, rating SMALLINT NOT NULL, CONSTRAINT FK_8A3E6797A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8A3E67971137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_album_rating (id, user_id, album_id, rating) SELECT id, user_id, album_id, rating FROM __temp__user_album_rating');
        $this->addSql('DROP TABLE __temp__user_album_rating');
        $this->addSql('CREATE INDEX IDX_8A3E67971137ABCF ON user_album_rating (album_id)');
        $this->addSql('CREATE INDEX IDX_8A3E6797A76ED395 ON user_album_rating (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__album AS SELECT id, title, artist, year, image_path, global_rating, wikipedia, spotify, youtube FROM album');
        $this->addSql('DROP TABLE album');
        $this->addSql('CREATE TABLE album (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, year SMALLINT NOT NULL, image_path VARCHAR(255) NOT NULL, wikipedia VARCHAR(255) DEFAULT NULL, spotify VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, global_ranking SMALLINT DEFAULT NULL)');
        $this->addSql('INSERT INTO album (id, title, artist, year, image_path, global_ranking, wikipedia, spotify, youtube) SELECT id, title, artist, year, image_path, global_rating, wikipedia, spotify, youtube FROM __temp__album');
        $this->addSql('DROP TABLE __temp__album');
        $this->addSql('DROP INDEX IDX_6DC044C5642B8210');
        $this->addSql('DROP INDEX IDX_6DC044C5213C1059');
        $this->addSql('CREATE TEMPORARY TABLE __temp__group AS SELECT id, admin_id, party_id, name FROM "group"');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('CREATE TABLE "group" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_id INTEGER NOT NULL, party_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO "group" (id, admin_id, party_id, name) SELECT id, admin_id, party_id, name FROM __temp__group');
        $this->addSql('DROP TABLE __temp__group');
        $this->addSql('CREATE INDEX IDX_6DC044C5642B8210 ON "group" (admin_id)');
        $this->addSql('CREATE INDEX IDX_6DC044C5213C1059 ON "group" (party_id)');
        $this->addSql('DROP INDEX IDX_89954EE08C4FD1E5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__party AS SELECT id, current_album_id, name, interval FROM party');
        $this->addSql('DROP TABLE party');
        $this->addSql('CREATE TABLE party (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, current_album_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, interval SMALLINT NOT NULL)');
        $this->addSql('INSERT INTO party (id, current_album_id, name, interval) SELECT id, current_album_id, name, interval FROM __temp__party');
        $this->addSql('DROP TABLE __temp__party');
        $this->addSql('CREATE INDEX IDX_89954EE08C4FD1E5 ON party (current_album_id)');
        $this->addSql('DROP INDEX IDX_34BC699D213C1059');
        $this->addSql('DROP INDEX IDX_34BC699D1137ABCF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__party_albums_done AS SELECT party_id, album_id FROM party_albums_done');
        $this->addSql('DROP TABLE party_albums_done');
        $this->addSql('CREATE TABLE party_albums_done (party_id INTEGER NOT NULL, album_id INTEGER NOT NULL, PRIMARY KEY(party_id, album_id))');
        $this->addSql('INSERT INTO party_albums_done (party_id, album_id) SELECT party_id, album_id FROM __temp__party_albums_done');
        $this->addSql('DROP TABLE __temp__party_albums_done');
        $this->addSql('CREATE INDEX IDX_34BC699D213C1059 ON party_albums_done (party_id)');
        $this->addSql('CREATE INDEX IDX_34BC699D1137ABCF ON party_albums_done (album_id)');
        $this->addSql('DROP INDEX IDX_5EF66E5E213C1059');
        $this->addSql('DROP INDEX IDX_5EF66E5E1137ABCF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__party_albums_left AS SELECT party_id, album_id FROM party_albums_left');
        $this->addSql('DROP TABLE party_albums_left');
        $this->addSql('CREATE TABLE party_albums_left (party_id INTEGER NOT NULL, album_id INTEGER NOT NULL, PRIMARY KEY(party_id, album_id))');
        $this->addSql('INSERT INTO party_albums_left (party_id, album_id) SELECT party_id, album_id FROM __temp__party_albums_left');
        $this->addSql('DROP TABLE __temp__party_albums_left');
        $this->addSql('CREATE INDEX IDX_5EF66E5E213C1059 ON party_albums_left (party_id)');
        $this->addSql('CREATE INDEX IDX_5EF66E5E1137ABCF ON party_albums_left (album_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('DROP INDEX IDX_8D93D649213C1059');
        $this->addSql('DROP INDEX IDX_8D93D6491ED93D47');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, party_id, user_group_id, username, roles, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, party_id INTEGER DEFAULT NULL, user_group_id INTEGER DEFAULT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, party_id, user_group_id, username, roles, password) SELECT id, party_id, user_group_id, username, roles, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE INDEX IDX_8D93D649213C1059 ON user (party_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491ED93D47 ON user (user_group_id)');
        $this->addSql('DROP INDEX IDX_8A3E6797A76ED395');
        $this->addSql('DROP INDEX IDX_8A3E67971137ABCF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_album_rating AS SELECT id, user_id, album_id, rating FROM user_album_rating');
        $this->addSql('DROP TABLE user_album_rating');
        $this->addSql('CREATE TABLE user_album_rating (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, album_id INTEGER NOT NULL, rating SMALLINT NOT NULL)');
        $this->addSql('INSERT INTO user_album_rating (id, user_id, album_id, rating) SELECT id, user_id, album_id, rating FROM __temp__user_album_rating');
        $this->addSql('DROP TABLE __temp__user_album_rating');
        $this->addSql('CREATE INDEX IDX_8A3E6797A76ED395 ON user_album_rating (user_id)');
        $this->addSql('CREATE INDEX IDX_8A3E67971137ABCF ON user_album_rating (album_id)');
    }
}
