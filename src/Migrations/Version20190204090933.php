<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190204090933 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL,description VARCHAR(255),code VARCHAR(255),value VARCHAR(255), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE template (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resources (id INT AUTO_INCREMENT NOT NULL, parent INT, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, is_publish TINYINT(1) NOT NULL, template_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_types (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, attributes VARCHAR(255) NOT NULL, structure JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fields (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type_id INT NOT NULL, template_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql("INSERT INTO `settings` (`id`, `title`, `description`, `code`, `value`) VALUES (NULL, 'home', 'home page id', 'home_page', '1');");
        $this->addSql("INSERT INTO `settings` (`id`, `title`, `description`, `code`, `value`) VALUES (NULL, 'site_url', 'site url', 'site_url', 's-project.loc');");
        $this->addSql("INSERT INTO `template` (`id`, `title`) VALUES (1, 'default');");
        $this->addSql("INSERT INTO `resources` (`id`, `parent`, `name`, `slug`, `description`, `content`, `is_active`, `is_publish`, `template_id`) VALUES (1, 0, 'page1', 'page1', 'wwwwwwwwwwwwwww', 'wwwwwwwwwwwwwww', 1, 1, 1);");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE template');
        $this->addSql('DROP TABLE resources');
        $this->addSql('DROP TABLE field_types');
        $this->addSql('DROP TABLE fields');
    }
}
