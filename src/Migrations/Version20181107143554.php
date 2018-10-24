<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181107143554 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->createSponsorshipBenefitTable($schema);
        $this->createSponsorshipLevelTable($schema);
        $this->createSponsorshipLevelBenefitTable($schema);
    }

    private function createSponsorshipBenefitTable(Schema $schema): void
    {
        $table = $schema->createTable('sponsorship_benefit');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('label', Type::STRING, ['length' => 255]);
        $table->addColumn('position', Type::INTEGER, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
    }

    private function createSponsorshipLevelTable(Schema $schema): void
    {
        $table = $schema->createTable('sponsorship_level');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('label', Type::STRING, ['length' => 255]);
        $table->addColumn('price', Type::FLOAT);
        $table->addColumn('position', Type::INTEGER, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
    }

    private function createSponsorshipLevelBenefitTable(Schema $schema): void
    {
        $table = $schema->createTable('sponsorship_level_benefit');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('sponsorship_level_id', Type::GUID);
        $table->addColumn('sponsorship_benefit_id', Type::GUID);
        $table->addColumn('content', Type::TEXT, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
        $table->addIndex(['sponsorship_level_id']);
        $table->addIndex(['sponsorship_benefit_id']);
        $table->addForeignKeyConstraint('sponsorship_level', ['sponsorship_level_id'], ['id']);
        $table->addForeignKeyConstraint('sponsorship_benefit', ['sponsorship_benefit_id'], ['id']);
    }

    public function down(Schema $schema) : void
    {
        if ($schema->hasTable('sponsorship_benefit')) {
            $schema->dropTable('sponsorship_benefit');
        }

        if ($schema->hasTable('sponsorship_level')) {
            $schema->dropTable('sponsorship_level');
        }

        if ($schema->hasTable('sponsorship_level_benefit')) {
            $schema->dropTable('sponsorship_level_benefit');
        }
    }
}
