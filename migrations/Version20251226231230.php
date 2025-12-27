<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251226231230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crea el usuario super administrador desde las variables de entorno';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }

     public function postUp(Schema $schema): void
    {
        // Obtener las variables de entorno directamente
        $email = $_ENV['SUPER_EMAIL'] ?? null;
        $password = $_ENV['SUPER_PASSWORD'] ?? null;

        if (!$email || !$password) {
            $this->write('Las variables SUPER_EMAIL y SUPER_PASSWORD no están definidas. Saltando creación de usuario.');
            return;
        }

        // Hashear la contraseña usando password_hash nativo de PHP
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insertar el usuario directamente con SQL
        $this->connection->insert('user', [
            'email' => $email,
            'password' => $hashedPassword,
            'roles' => json_encode(['ROLE_SUPER_ADMIN'])
        ]);

        $this->write('Usuario super administrador creado exitosamente.');
    }

    public function postDown(Schema $schema): void
    {
        $email = $_ENV['SUPER_EMAIL'] ?? null;
        
        if ($email) {
            $this->connection->delete('user', ['email' => $email]);
            $this->write('Usuario super administrador eliminado.');
        }
    }
}
