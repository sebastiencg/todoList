<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531204358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE todo_profile (todo_id INT NOT NULL, profile_id INT NOT NULL, PRIMARY KEY(todo_id, profile_id))');
        $this->addSql('CREATE INDEX IDX_545E607EEA1EBC33 ON todo_profile (todo_id)');
        $this->addSql('CREATE INDEX IDX_545E607ECCFA12B8 ON todo_profile (profile_id)');
        $this->addSql('ALTER TABLE todo_profile ADD CONSTRAINT FK_545E607EEA1EBC33 FOREIGN KEY (todo_id) REFERENCES todo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE todo_profile ADD CONSTRAINT FK_545E607ECCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE todo_profile DROP CONSTRAINT FK_545E607EEA1EBC33');
        $this->addSql('ALTER TABLE todo_profile DROP CONSTRAINT FK_545E607ECCFA12B8');
        $this->addSql('DROP TABLE todo_profile');
    }
}
