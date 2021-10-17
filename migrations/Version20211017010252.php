<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211017010252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE film_persons DROP FOREIGN KEY FK_956E3E94567F5183');
        $this->addSql('ALTER TABLE film_persons DROP FOREIGN KEY FK_956E3E94FE812AD');
        $this->addSql('DROP INDEX idx_956e3e94567f5183 ON film_persons');
        $this->addSql('CREATE INDEX IDX_42E2DCF0567F5183 ON film_persons (film_id)');
        $this->addSql('DROP INDEX idx_956e3e94fe812ad ON film_persons');
        $this->addSql('CREATE INDEX IDX_42E2DCF0FE812AD ON film_persons (persons_id)');
        $this->addSql('ALTER TABLE film_persons ADD CONSTRAINT FK_956E3E94567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_persons ADD CONSTRAINT FK_956E3E94FE812AD FOREIGN KEY (persons_id) REFERENCES persons (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE film_persons DROP FOREIGN KEY FK_42E2DCF0567F5183');
        $this->addSql('ALTER TABLE film_persons DROP FOREIGN KEY FK_42E2DCF0FE812AD');
        $this->addSql('DROP INDEX idx_42e2dcf0fe812ad ON film_persons');
        $this->addSql('CREATE INDEX IDX_956E3E94FE812AD ON film_persons (persons_id)');
        $this->addSql('DROP INDEX idx_42e2dcf0567f5183 ON film_persons');
        $this->addSql('CREATE INDEX IDX_956E3E94567F5183 ON film_persons (film_id)');
        $this->addSql('ALTER TABLE film_persons ADD CONSTRAINT FK_42E2DCF0567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_persons ADD CONSTRAINT FK_42E2DCF0FE812AD FOREIGN KEY (persons_id) REFERENCES persons (id) ON DELETE CASCADE');
    }
}
