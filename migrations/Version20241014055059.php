<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014055059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creating the following entities : ingredient, measure_unit, recipe, recipe_type, season, step, user';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, number INT NOT NULL, measure_unit_id INT DEFAULT NULL, recipe_id INT NOT NULL, INDEX IDX_6BAF787063C6A475 (measure_unit_id), INDEX IDX_6BAF787059D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE measure_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, preparation_time INT DEFAULT NULL, is_vegetarian TINYINT(1) NOT NULL, is_vegan TINYINT(1) NOT NULL, owner_id INT NOT NULL, INDEX IDX_DA88B1377E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_type_recipe (recipe_type_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_2DAD946B89A882D3 (recipe_type_id), INDEX IDX_2DAD946B59D8A214 (recipe_id), PRIMARY KEY(recipe_type_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE season_recipe (season_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_CCF34F854EC001D1 (season_id), INDEX IDX_CCF34F8559D8A214 (recipe_id), PRIMARY KEY(season_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, description VARCHAR(255) NOT NULL, recipe_id INT NOT NULL, INDEX IDX_43B9FE3C59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, cooking_level INT DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_PSEUDO (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user_recipe (user_id INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_BFDAAA0AA76ED395 (user_id), INDEX IDX_BFDAAA0A59D8A214 (recipe_id), PRIMARY KEY(user_id, recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787063C6A475 FOREIGN KEY (measure_unit_id) REFERENCES measure_unit (id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1377E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe_type_recipe ADD CONSTRAINT FK_2DAD946B89A882D3 FOREIGN KEY (recipe_type_id) REFERENCES recipe_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_type_recipe ADD CONSTRAINT FK_2DAD946B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season_recipe ADD CONSTRAINT FK_CCF34F854EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE season_recipe ADD CONSTRAINT FK_CCF34F8559D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE user_recipe ADD CONSTRAINT FK_BFDAAA0AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_recipe ADD CONSTRAINT FK_BFDAAA0A59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787063C6A475');
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787059D8A214');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1377E3C61F9');
        $this->addSql('ALTER TABLE recipe_type_recipe DROP FOREIGN KEY FK_2DAD946B89A882D3');
        $this->addSql('ALTER TABLE recipe_type_recipe DROP FOREIGN KEY FK_2DAD946B59D8A214');
        $this->addSql('ALTER TABLE season_recipe DROP FOREIGN KEY FK_CCF34F854EC001D1');
        $this->addSql('ALTER TABLE season_recipe DROP FOREIGN KEY FK_CCF34F8559D8A214');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C59D8A214');
        $this->addSql('ALTER TABLE user_recipe DROP FOREIGN KEY FK_BFDAAA0AA76ED395');
        $this->addSql('ALTER TABLE user_recipe DROP FOREIGN KEY FK_BFDAAA0A59D8A214');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE measure_unit');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_type');
        $this->addSql('DROP TABLE recipe_type_recipe');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE season_recipe');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_recipe');
    }
}
