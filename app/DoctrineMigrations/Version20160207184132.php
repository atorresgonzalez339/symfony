<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160207184132 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, for_rent TINYINT(1) NOT NULL, lease_term VARCHAR(255) NOT NULL, bedrooms SMALLINT NOT NULL, baths_full SMALLINT NOT NULL, baths_half SMALLINT NOT NULL, laundry TINYINT(1) NOT NULL, view VARCHAR(100) DEFAULT NULL, lot_size VARCHAR(100) DEFAULT NULL, year_built SMALLINT DEFAULT NULL, accessibility LONGTEXT DEFAULT NULL, mls_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, unit VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, postal_code SMALLINT NOT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, price INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_photos (id INT AUTO_INCREMENT NOT NULL, propery_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_76018FA57A29BAF3 (propery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property_photos ADD CONSTRAINT FK_76018FA57A29BAF3 FOREIGN KEY (propery_id) REFERENCES property (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property_photos DROP FOREIGN KEY FK_76018FA57A29BAF3');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_photos');
    }
}
