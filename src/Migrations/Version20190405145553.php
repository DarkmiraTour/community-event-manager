<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190405145553 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE speaker_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('ALTER TABLE space_type ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE space ALTER type_id DROP NOT NULL');
        $this->addSql('ALTER TABLE space ALTER schedule_id DROP NOT NULL');
        $this->addSql('DROP INDEX uniq_e6e132b4bf396750');
        $this->addSql('ALTER TABLE events ALTER address_id DROP NOT NULL');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5387574AF5B7AF75 ON events (address_id)');
        $this->addSql('ALTER TABLE sponsorship_level_benefit ALTER content TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE sponsorship_level_benefit ALTER content DROP DEFAULT');
        $this->addSql('DROP INDEX idx_ac0e20676f0601d5');
        $this->addSql('ALTER TABLE slot ALTER type_id DROP NOT NULL');
        $this->addSql('ALTER TABLE slot ALTER space_id DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC0E20676F0601D5 ON slot (talk_id)');
        $this->addSql('DROP INDEX uniq_9f24d5bbbf396750');
        $this->addSql('ALTER TABLE talk ALTER speaker_id DROP NOT NULL');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BBD04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9F24D5BBD04A0F27 ON talk (speaker_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE speaker_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE talk DROP CONSTRAINT FK_9F24D5BBD04A0F27');
        $this->addSql('DROP INDEX IDX_9F24D5BBD04A0F27');
        $this->addSql('ALTER TABLE talk ALTER speaker_id SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_9f24d5bbbf396750 ON talk (id)');
        $this->addSql('ALTER TABLE sponsorship_level_benefit ALTER content TYPE TEXT');
        $this->addSql('ALTER TABLE sponsorship_level_benefit ALTER content DROP DEFAULT');
        $this->addSql('CREATE UNIQUE INDEX uniq_e6e132b4bf396750 ON organisation (id)');
        $this->addSql('ALTER TABLE space_type ALTER name TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE space ALTER type_id SET NOT NULL');
        $this->addSql('ALTER TABLE space ALTER schedule_id SET NOT NULL');
        $this->addSql('DROP INDEX UNIQ_AC0E20676F0601D5');
        $this->addSql('ALTER TABLE slot ALTER type_id SET NOT NULL');
        $this->addSql('ALTER TABLE slot ALTER space_id SET NOT NULL');
        $this->addSql('CREATE INDEX idx_ac0e20676f0601d5 ON slot (talk_id)');
        $this->addSql('ALTER TABLE address ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574AF5B7AF75');
        $this->addSql('DROP INDEX IDX_5387574AF5B7AF75');
        $this->addSql('ALTER TABLE events ALTER address_id SET NOT NULL');
    }
}
