<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190715123332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, composer_id INT DEFAULT NULL, intitule VARCHAR(150) NOT NULL, nb_places INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, INDEX IDX_D044D5D47A8D2620 (composer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_stagiaire (session_id INT NOT NULL, stagiaire_id INT NOT NULL, INDEX IDX_C80B23B613FECDF (session_id), INDEX IDX_C80B23BBBA93DD6 (stagiaire_id), PRIMARY KEY(session_id, stagiaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(100) NOT NULL, genre VARCHAR(20) NOT NULL, date_naissance DATETIME NOT NULL, ville VARCHAR(75) NOT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur_categorie (formateur_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_5B796C83155D8F51 (formateur_id), INDEX IDX_5B796C83BCF5E72D (categorie_id), PRIMARY KEY(formateur_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, genre VARCHAR(15) NOT NULL, date_naissance DATETIME NOT NULL, ville VARCHAR(75) NOT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composer (id INT AUTO_INCREMENT NOT NULL, nb_jours INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modul (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, composer_id INT DEFAULT NULL, initule VARCHAR(150) NOT NULL, INDEX IDX_9D576088BCF5E72D (categorie_id), INDEX IDX_9D5760887A8D2620 (composer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D47A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id)');
        $this->addSql('ALTER TABLE session_stagiaire ADD CONSTRAINT FK_C80B23B613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session_stagiaire ADD CONSTRAINT FK_C80B23BBBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formateur_categorie ADD CONSTRAINT FK_5B796C83155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formateur_categorie ADD CONSTRAINT FK_5B796C83BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modul ADD CONSTRAINT FK_9D576088BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE modul ADD CONSTRAINT FK_9D5760887A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE session_stagiaire DROP FOREIGN KEY FK_C80B23B613FECDF');
        $this->addSql('ALTER TABLE formateur_categorie DROP FOREIGN KEY FK_5B796C83155D8F51');
        $this->addSql('ALTER TABLE session_stagiaire DROP FOREIGN KEY FK_C80B23BBBA93DD6');
        $this->addSql('ALTER TABLE formateur_categorie DROP FOREIGN KEY FK_5B796C83BCF5E72D');
        $this->addSql('ALTER TABLE modul DROP FOREIGN KEY FK_9D576088BCF5E72D');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D47A8D2620');
        $this->addSql('ALTER TABLE modul DROP FOREIGN KEY FK_9D5760887A8D2620');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_stagiaire');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE formateur_categorie');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE composer');
        $this->addSql('DROP TABLE modul');
        $this->addSql('DROP TABLE user');
    }
}
