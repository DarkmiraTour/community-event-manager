<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181107143554 extends AbstractMigration
{
    private const SPONSORSHIP_BENEFIT_TABLE_NAME = 'sponsorship_benefit';
    private const SPONSORSHIP_LEVEL_TABLE_NAME = 'sponsorship_level';
    private const SPONSORSHIP_LEVEL_BENEFIT_TABLE_NAME = 'sponsorship_level_benefit';

    public function up(Schema $schema): void
    {
        $this->createSponsorshipBenefitTable($schema);
        $this->createSponsorshipLevelTable($schema);
        $this->createSponsorshipLevelBenefitTable($schema);
    }

    private function createSponsorshipBenefitTable(Schema $schema): void
    {
        $table = $schema->createTable(self::SPONSORSHIP_BENEFIT_TABLE_NAME);
        $table->addColumn('id', Type::GUID);
        $table->addColumn('label', Type::STRING, ['length' => 255]);
        $table->addColumn('position', Type::INTEGER, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
    }

    private function createSponsorshipLevelTable(Schema $schema): void
    {
        $table = $schema->createTable(self::SPONSORSHIP_LEVEL_TABLE_NAME);
        $table->addColumn('id', Type::GUID);
        $table->addColumn('label', Type::STRING, ['length' => 255]);
        $table->addColumn('price', Type::FLOAT);
        $table->addColumn('position', Type::INTEGER, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
    }

    private function createSponsorshipLevelBenefitTable(Schema $schema): void
    {
        $table = $schema->createTable(self::SPONSORSHIP_LEVEL_BENEFIT_TABLE_NAME);
        $table->addColumn('id', Type::GUID);
        $table->addColumn('sponsorship_level_id', Type::GUID);
        $table->addColumn('sponsorship_benefit_id', Type::GUID);
        $table->addColumn('content', Type::TEXT, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['sponsorship_level_id']);
        $table->addIndex(['sponsorship_benefit_id']);
        $table->addForeignKeyConstraint(self::SPONSORSHIP_LEVEL_TABLE_NAME, ['sponsorship_level_id'], ['id']);
        $table->addForeignKeyConstraint(self::SPONSORSHIP_BENEFIT_TABLE_NAME, ['sponsorship_benefit_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::SPONSORSHIP_LEVEL_BENEFIT_TABLE_NAME);
        $schema->dropTable(self::SPONSORSHIP_BENEFIT_TABLE_NAME);
        $schema->dropTable(self::SPONSORSHIP_LEVEL_TABLE_NAME);
    }
}
