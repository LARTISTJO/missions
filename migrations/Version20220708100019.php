<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220708100019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE studies ADD studycreator_id INT NOT NULL');
        $this->addSql('ALTER TABLE studies ADD CONSTRAINT FK_C3A91A3FB8791D2A FOREIGN KEY (studycreator_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_C3A91A3FB8791D2A ON studies (studycreator_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE studies DROP FOREIGN KEY FK_C3A91A3FB8791D2A');
        $this->addSql('DROP INDEX IDX_C3A91A3FB8791D2A ON studies');
        $this->addSql('ALTER TABLE studies DROP studycreator_id');
    }
}
