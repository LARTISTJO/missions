<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707161933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agenda (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, professor_id INT DEFAULT NULL, study_id INT DEFAULT NULL, informations LONGTEXT NOT NULL, start DATETIME DEFAULT NULL, ending DATETIME DEFAULT NULL, INDEX IDX_2CEDC877CB944F1A (student_id), INDEX IDX_2CEDC8777D2D84D5 (professor_id), INDEX IDX_2CEDC877E7B003E9 (study_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professor (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_790DD7E3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studies (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studies_themes (studies_id INT NOT NULL, themes_id INT NOT NULL, INDEX IDX_9D89D14565186C9 (studies_id), INDEX IDX_9D89D1494F4A9D2 (themes_id), PRIMARY KEY(studies_id, themes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE themes (id INT AUTO_INCREMENT NOT NULL, themecreator_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_154232DEE27D7536 (themecreator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, professor_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6497D2D84D5 (professor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC877CB944F1A FOREIGN KEY (student_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC8777D2D84D5 FOREIGN KEY (professor_id) REFERENCES professor (id)');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC877E7B003E9 FOREIGN KEY (study_id) REFERENCES studies (id)');
        $this->addSql('ALTER TABLE studies_themes ADD CONSTRAINT FK_9D89D14565186C9 FOREIGN KEY (studies_id) REFERENCES studies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE studies_themes ADD CONSTRAINT FK_9D89D1494F4A9D2 FOREIGN KEY (themes_id) REFERENCES themes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE themes ADD CONSTRAINT FK_154232DEE27D7536 FOREIGN KEY (themecreator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6497D2D84D5 FOREIGN KEY (professor_id) REFERENCES professor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agenda DROP FOREIGN KEY FK_2CEDC8777D2D84D5');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6497D2D84D5');
        $this->addSql('ALTER TABLE agenda DROP FOREIGN KEY FK_2CEDC877E7B003E9');
        $this->addSql('ALTER TABLE studies_themes DROP FOREIGN KEY FK_9D89D14565186C9');
        $this->addSql('ALTER TABLE studies_themes DROP FOREIGN KEY FK_9D89D1494F4A9D2');
        $this->addSql('ALTER TABLE agenda DROP FOREIGN KEY FK_2CEDC877CB944F1A');
        $this->addSql('ALTER TABLE themes DROP FOREIGN KEY FK_154232DEE27D7536');
        $this->addSql('DROP TABLE agenda');
        $this->addSql('DROP TABLE professor');
        $this->addSql('DROP TABLE studies');
        $this->addSql('DROP TABLE studies_themes');
        $this->addSql('DROP TABLE themes');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
