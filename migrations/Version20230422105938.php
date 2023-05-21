<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422105938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE USING created_at::timestamp(0) without time zone');
        $this->addSql('ALTER TABLE notification ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE notification ALTER sent_at DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN notification.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ALTER created_at TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE notification ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE notification ALTER sent_at SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN notification.created_at IS NULL');
    }
}
