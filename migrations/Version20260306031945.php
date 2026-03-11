<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260306031945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proyecto (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, descripcion_breve LONGTEXT NOT NULL, portada_nombre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE proyecto_imagen (id INT AUTO_INCREMENT NOT NULL, imagen_nombre VARCHAR(255) DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, proyecto_id INT NOT NULL, INDEX IDX_127F5524F625D1BA (proyecto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE proyecto_imagen ADD CONSTRAINT FK_127F5524F625D1BA FOREIGN KEY (proyecto_id) REFERENCES proyecto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proyecto_imagen DROP FOREIGN KEY FK_127F5524F625D1BA');
        $this->addSql('DROP TABLE proyecto');
        $this->addSql('DROP TABLE proyecto_imagen');
    }
}
