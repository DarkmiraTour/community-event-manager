<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190416111111 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE organisation_sponsor (id UUID NOT NULL, organisation_id UUID DEFAULT NULL, event_id UUID DEFAULT NULL, special_benefit_id UUID DEFAULT NULL, sponsorship_level_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E208BED79E6B1585 ON organisation_sponsor (organisation_id)');
        $this->addSql('CREATE INDEX IDX_E208BED771F7E88B ON organisation_sponsor (event_id)');
        $this->addSql('CREATE INDEX IDX_E208BED7EF315F39 ON organisation_sponsor (special_benefit_id)');
        $this->addSql('CREATE INDEX IDX_E208BED7BCD42464 ON organisation_sponsor (sponsorship_level_id)');
        $this->addSql('ALTER TABLE organisation_sponsor ADD CONSTRAINT FK_E208BED79E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organisation_sponsor ADD CONSTRAINT FK_E208BED771F7E88B FOREIGN KEY (event_id) REFERENCES events (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organisation_sponsor ADD CONSTRAINT FK_E208BED7EF315F39 FOREIGN KEY (special_benefit_id) REFERENCES special_benefit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organisation_sponsor ADD CONSTRAINT FK_E208BED7BCD42464 FOREIGN KEY (sponsorship_level_id) REFERENCES sponsorship_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE organisation_sponsor');
    }
}
