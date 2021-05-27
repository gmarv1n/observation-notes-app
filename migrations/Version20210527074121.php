<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210527074121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE days_objects_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE days_observers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE observer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE observing_day_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE observing_object_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE days_objects (id INT NOT NULL, observing_day_id INT NOT NULL, observing_object_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE days_observers (id INT NOT NULL, observer_id INT NOT NULL, observing_day_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE observer (id INT NOT NULL, observer_name VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B6F44E75CBA0574 ON observer (observer_name)');
        $this->addSql('CREATE TABLE observing_day (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, day_description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE observing_object (id INT NOT NULL, object_name VARCHAR(255) NOT NULL, object_description TEXT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE days_objects_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE days_observers_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE observer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE observing_day_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE observing_object_id_seq CASCADE');
        $this->addSql('DROP TABLE days_objects');
        $this->addSql('DROP TABLE days_observers');
        $this->addSql('DROP TABLE observer');
        $this->addSql('DROP TABLE observing_day');
        $this->addSql('DROP TABLE observing_object');
    }
}
