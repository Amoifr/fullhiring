<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812170923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fleet (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_A05E1E47A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, fleet_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6494B061DF9 (fleet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, fleet_id INT NOT NULL, location JSON NOT NULL, plate_number VARCHAR(255) NOT NULL, INDEX IDX_1B80E4864B061DF9 (fleet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fleet ADD CONSTRAINT FK_A05E1E47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4864B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fleet DROP FOREIGN KEY FK_A05E1E47A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494B061DF9');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4864B061DF9');
        $this->addSql('DROP TABLE fleet');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicle');
    }
}
