<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200805230216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cleaning_schedule (id INT AUTO_INCREMENT NOT NULL COMMENT \'(DC2Type:cleaning_schedule_id)\', cleaning_subscription_id INT DEFAULT NULL, parent_cleaning_schedule_id INT DEFAULT NULL COMMENT \'(DC2Type:cleaning_schedule_id)\', type ENUM(\'WEEKLY\',\'MONTHLY\',\'DEPENDENT\') COMMENT \'(DC2Type:enum_cleaning_schedule_type)\' NOT NULL, INDEX IDX_F51E543AF46E5BCB (cleaning_subscription_id), INDEX IDX_F51E543ACF765942 (parent_cleaning_schedule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cleaning_schedule_monthly (id INT NOT NULL COMMENT \'(DC2Type:cleaning_schedule_id)\', monthly_schedule ENUM(\'FIRST_DAY_OF_THE_MONTH\',\'FIRST_WORKING_DAY_OF_THE_MONTH\',\'LAST_DAY_OF_THE_MONTH\',\'LAST_WORKING_DAY_OF_THE_MONTH\') COMMENT \'(DC2Type:enum_monthly_schedule)\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cleaning_schedule_weekly (id INT NOT NULL COMMENT \'(DC2Type:cleaning_schedule_id)\', monday TINYINT(1) NOT NULL, tuesday TINYINT(1) NOT NULL, wednesday TINYINT(1) NOT NULL, thursday TINYINT(1) NOT NULL, friday TINYINT(1) NOT NULL, saturday TINYINT(1) NOT NULL, sunday TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cleaning_service (id INT AUTO_INCREMENT NOT NULL COMMENT \'(DC2Type:cleaning_service_id)\', name VARCHAR(255) NOT NULL, time_in_minutes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cleaning_subscription (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL COMMENT \'(DC2Type:location_id)\', cleaning_service_id INT DEFAULT NULL COMMENT \'(DC2Type:cleaning_service_id)\', INDEX IDX_9ED19FC664D218E (location_id), INDEX IDX_9ED19FC6390B55D0 (cleaning_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL COMMENT \'(DC2Type:location_id)\', name VARCHAR(255) NOT NULL, address_street VARCHAR(255) NOT NULL, address_house_number INT NOT NULL, address_house_number_addition VARCHAR(255) DEFAULT NULL, address_postal_code VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_country VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE national_holiday (id INT AUTO_INCREMENT NOT NULL COMMENT \'(DC2Type:national_holiday_id)\', date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', name VARCHAR(255) NOT NULL, day_off TINYINT(1) NOT NULL, country VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cleaning_schedule ADD CONSTRAINT FK_F51E543AF46E5BCB FOREIGN KEY (cleaning_subscription_id) REFERENCES cleaning_subscription (id)');
        $this->addSql('ALTER TABLE cleaning_schedule ADD CONSTRAINT FK_F51E543ACF765942 FOREIGN KEY (parent_cleaning_schedule_id) REFERENCES cleaning_schedule (id)');
        $this->addSql('ALTER TABLE cleaning_schedule_monthly ADD CONSTRAINT FK_E4721932BF396750 FOREIGN KEY (id) REFERENCES cleaning_schedule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cleaning_schedule_weekly ADD CONSTRAINT FK_528B322CBF396750 FOREIGN KEY (id) REFERENCES cleaning_schedule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cleaning_subscription ADD CONSTRAINT FK_9ED19FC664D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE cleaning_subscription ADD CONSTRAINT FK_9ED19FC6390B55D0 FOREIGN KEY (cleaning_service_id) REFERENCES cleaning_service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cleaning_schedule DROP FOREIGN KEY FK_F51E543ACF765942');
        $this->addSql('ALTER TABLE cleaning_schedule_monthly DROP FOREIGN KEY FK_E4721932BF396750');
        $this->addSql('ALTER TABLE cleaning_schedule_weekly DROP FOREIGN KEY FK_528B322CBF396750');
        $this->addSql('ALTER TABLE cleaning_subscription DROP FOREIGN KEY FK_9ED19FC6390B55D0');
        $this->addSql('ALTER TABLE cleaning_schedule DROP FOREIGN KEY FK_F51E543AF46E5BCB');
        $this->addSql('ALTER TABLE cleaning_subscription DROP FOREIGN KEY FK_9ED19FC664D218E');
        $this->addSql('DROP TABLE cleaning_schedule');
        $this->addSql('DROP TABLE cleaning_schedule_monthly');
        $this->addSql('DROP TABLE cleaning_schedule_weekly');
        $this->addSql('DROP TABLE cleaning_service');
        $this->addSql('DROP TABLE cleaning_subscription');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE national_holiday');
    }
}
