<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181129133023 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->createSlotTypeTable($schema);
        $this->createSpaceTypeTable($schema);
        $this->createScheduleTable($schema);
        $this->createSpaceTable($schema);
        $this->createSlotTable($schema);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('slot_type');
        $schema->dropTable('space_type');
        $schema->dropTable('slot');
        $schema->dropTable('space');
        $schema->dropTable('schedule');
    }

    private function createSlotTypeTable(Schema $schema): void
    {
        $table = $schema->createTable('slot_type');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('description', Type::STRING, ['length' => 50]);

        $table->setPrimaryKey(['id']);
    }

    private function createSpaceTypeTable(Schema $schema): void
    {
        $table = $schema->createTable('space_type');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('name', Type::STRING, ['length' => 100]);
        $table->addColumn('description', Type::STRING, ['length' => 255]);

        $table->setPrimaryKey(['id']);
    }

    private function createScheduleTable(Schema $schema): void
    {
        $table = $schema->createTable('schedule');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('day', Type::DATE);
        $table->setPrimaryKey(['id']);
    }

    private function createSpaceTable(Schema $schema): void
    {
        $table = $schema->createTable('space');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('type_id', Type::GUID);
        $table->addColumn('schedule_id', Type::GUID);
        $table->addColumn('name', Type::STRING, ['length' => 50]);
        $table->addColumn('visible', Type::BOOLEAN);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['type_id']);
        $table->addIndex(['schedule_id']);
        $table->addForeignKeyConstraint('space_type', ['type_id'], ['id']);
        $table->addForeignKeyConstraint('schedule', ['schedule_id'], ['id']);
    }

    private function createSlotTable(Schema $schema): void
    {
        $table = $schema->createTable('slot');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('type_id', Type::GUID);
        $table->addColumn('space_id', Type::GUID);
        $table->addColumn('title', Type::STRING, ['length' => 50]);
        $table->addColumn('duration', Type::INTEGER);
        $table->addColumn('start', Type::TIME);
        $table->addColumn('time_end', Type::TIME);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['type_id']);
        $table->addIndex(['space_id']);
        $table->addForeignKeyConstraint('slot_type', ['type_id'], ['id']);
        $table->addForeignKeyConstraint('space', ['space_id'], ['id']);
    }
}
