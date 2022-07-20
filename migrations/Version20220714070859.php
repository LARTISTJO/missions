<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714070859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE studies_themes');
        $this->addSql('ALTER TABLE studies ADD studytheme_id INT NOT NULL');
        $this->addSql('ALTER TABLE studies ADD CONSTRAINT FK_C3A91A3F185F6898 FOREIGN KEY (studytheme_id) REFERENCES themes (id)');
        $this->addSql('CREATE INDEX IDX_C3A91A3F185F6898 ON studies (studytheme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE studies_themes (studies_id INT NOT NULL, themes_id INT NOT NULL, INDEX IDX_9D89D14565186C9 (studies_id), INDEX IDX_9D89D1494F4A9D2 (themes_id), PRIMARY KEY(studies_id, themes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE studies_themes ADD CONSTRAINT FK_9D89D14565186C9 FOREIGN KEY (studies_id) REFERENCES studies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studies_themes ADD CONSTRAINT FK_9D89D1494F4A9D2 FOREIGN KEY (themes_id) REFERENCES themes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studies DROP FOREIGN KEY FK_C3A91A3F185F6898');
        $this->addSql('DROP INDEX IDX_C3A91A3F185F6898 ON studies');
        $this->addSql('ALTER TABLE studies DROP studytheme_id');
    }
}
