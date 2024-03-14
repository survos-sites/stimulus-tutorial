<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314134720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE color_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE purchase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE purchase_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE color (id INT NOT NULL, name VARCHAR(100) NOT NULL, hex_color VARCHAR(6) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, brand VARCHAR(20) NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, price INT NOT NULL, stock_quantity INT NOT NULL, image_filename VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE TABLE product_color (product_id INT NOT NULL, color_id INT NOT NULL, PRIMARY KEY(product_id, color_id))');
        $this->addSql('CREATE INDEX IDX_C70A33B54584665A ON product_color (product_id)');
        $this->addSql('CREATE INDEX IDX_C70A33B57ADA1FB5 ON product_color (color_id)');
        $this->addSql('CREATE TABLE purchase (id INT NOT NULL, customer_name VARCHAR(255) NOT NULL, customer_email VARCHAR(255) NOT NULL, customer_address VARCHAR(255) NOT NULL, customer_zip VARCHAR(20) DEFAULT NULL, customer_city VARCHAR(255) NOT NULL, customer_phone VARCHAR(20) DEFAULT NULL, is_shipped BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE purchase_item (id INT NOT NULL, purchase_id INT NOT NULL, product_id INT NOT NULL, color_id INT DEFAULT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6FA8ED7D558FBEB9 ON purchase_item (purchase_id)');
        $this->addSql('CREATE INDEX IDX_6FA8ED7D4584665A ON purchase_item (product_id)');
        $this->addSql('CREATE INDEX IDX_6FA8ED7D7ADA1FB5 ON purchase_item (color_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_color ADD CONSTRAINT FK_C70A33B54584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_color ADD CONSTRAINT FK_C70A33B57ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase_item ADD CONSTRAINT FK_6FA8ED7D558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase_item ADD CONSTRAINT FK_6FA8ED7D4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase_item ADD CONSTRAINT FK_6FA8ED7D7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE color_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE purchase_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE purchase_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product_color DROP CONSTRAINT FK_C70A33B54584665A');
        $this->addSql('ALTER TABLE product_color DROP CONSTRAINT FK_C70A33B57ADA1FB5');
        $this->addSql('ALTER TABLE purchase_item DROP CONSTRAINT FK_6FA8ED7D558FBEB9');
        $this->addSql('ALTER TABLE purchase_item DROP CONSTRAINT FK_6FA8ED7D4584665A');
        $this->addSql('ALTER TABLE purchase_item DROP CONSTRAINT FK_6FA8ED7D7ADA1FB5');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_color');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE purchase_item');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
