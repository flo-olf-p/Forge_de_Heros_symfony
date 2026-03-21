<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260321113140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, level INTEGER NOT NULL, strength INTEGER NOT NULL, dexterity INTEGER NOT NULL, constitution INTEGER NOT NULL, intelligence INTEGER NOT NULL, wisdom INTEGER NOT NULL, charisma INTEGER NOT NULL, health_points INTEGER NOT NULL, user_id INTEGER NOT NULL, race_id INTEGER DEFAULT NULL, class_character_id INTEGER NOT NULL, CONSTRAINT FK_937AB034A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_937AB0346E59D40D FOREIGN KEY (race_id) REFERENCES race (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_937AB034DEB44523 FOREIGN KEY (class_character_id) REFERENCES character_class (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_937AB034A76ED395 ON character (user_id)');
        $this->addSql('CREATE INDEX IDX_937AB0346E59D40D ON character (race_id)');
        $this->addSql('CREATE INDEX IDX_937AB034DEB44523 ON character (class_character_id)');
        $this->addSql('CREATE TABLE character_party (character_id INTEGER NOT NULL, party_id INTEGER NOT NULL, PRIMARY KEY (character_id, party_id), CONSTRAINT FK_7756A9821136BE75 FOREIGN KEY (character_id) REFERENCES character (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7756A982213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7756A9821136BE75 ON character_party (character_id)');
        $this->addSql('CREATE INDEX IDX_7756A982213C1059 ON character_party (party_id)');
        $this->addSql('CREATE TABLE character_class (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, health_dice INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE character_class_skill (character_class_id INTEGER NOT NULL, skill_id INTEGER NOT NULL, PRIMARY KEY (character_class_id, skill_id), CONSTRAINT FK_BC806FEDB201E281 FOREIGN KEY (character_class_id) REFERENCES character_class (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BC806FED5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BC806FEDB201E281 ON character_class_skill (character_class_id)');
        $this->addSql('CREATE INDEX IDX_BC806FED5585C142 ON character_class_skill (skill_id)');
        $this->addSql('CREATE TABLE party (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, max_size INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE race (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE TABLE skill (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ability VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user_party (user_id INTEGER NOT NULL, party_id INTEGER NOT NULL, PRIMARY KEY (user_id, party_id), CONSTRAINT FK_6B57B5B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6B57B5B8213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6B57B5B8A76ED395 ON user_party (user_id)');
        $this->addSql('CREATE INDEX IDX_6B57B5B8213C1059 ON user_party (party_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE character');
        $this->addSql('DROP TABLE character_party');
        $this->addSql('DROP TABLE character_class');
        $this->addSql('DROP TABLE character_class_skill');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE user_party');
    }
}
