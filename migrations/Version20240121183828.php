<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121183828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "log"."request_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "cfg"."user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE log.request ADD CONSTRAINT FK_63A02606A76ED395 FOREIGN KEY (user_id) REFERENCES "cfg"."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "log"."request_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "cfg"."user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "log"."request" DROP CONSTRAINT FK_63A02606A76ED395');
    }
}
