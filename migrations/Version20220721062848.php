<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721062848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_manga_list (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, manga_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, number_of_volume INT NOT NULL, list_of_volume LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', status VARCHAR(255) DEFAULT NULL, INDEX IDX_BCFBD7BEA76ED395 (user_id), INDEX IDX_BCFBD7BE7B6461 (manga_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_manga_list ADD CONSTRAINT FK_BCFBD7BEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_manga_list ADD CONSTRAINT FK_BCFBD7BE7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_manga_list');
    }
}
