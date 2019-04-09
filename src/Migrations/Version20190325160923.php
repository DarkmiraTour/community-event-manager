<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Migrations\AbstractTableNameMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

final class Version20190325160923 extends AbstractTableNameMigration
{
    private const FIELD_EVENT_ID = 'event_id';

    public function up(Schema $schema): void
    {
        $tableEventSpeaker = $schema->createTable(self::EVENTS_SPEAKERS);
        $tableEventSpeaker->addColumn(self::FIELD_EVENT_ID, Type::GUID);
        $tableEventSpeaker->addColumn('speaker_id', Type::GUID);

        $tableEventSpeaker->setPrimaryKey(['speaker_id', self::FIELD_EVENT_ID]);
        $tableEventSpeaker->addForeignKeyConstraint(self::EVENT, [self::FIELD_EVENT_ID], ['id'], ['onDelete' => 'CASCADE']);
        $tableEventSpeaker->addForeignKeyConstraint(self::SPEAKER, ['speaker_id'], ['id'], ['onDelete' => 'CASCADE']);

        $tableEventOrganization = $schema->createTable(self::EVENTS_ORGANIZATIONS);
        $tableEventOrganization->addColumn(self::FIELD_EVENT_ID, Type::GUID);
        $tableEventOrganization->addColumn('organisation_id', Type::GUID);

        $tableEventOrganization->setPrimaryKey(['organisation_id', self::FIELD_EVENT_ID]);
        $tableEventOrganization->addForeignKeyConstraint(self::EVENT, [self::FIELD_EVENT_ID], ['id'], ['onDelete' => 'CASCADE']);
        $tableEventOrganization->addForeignKeyConstraint(self::ORGANIZATION, ['organisation_id'], ['id'], ['onDelete' => 'CASCADE']);

        $tableSchedule = $schema->getTable(self::SCHEDULE);
        $tableSchedule->addColumn(self::FIELD_EVENT_ID, Type::GUID, ['notnull' => false]);
        $tableSchedule->addForeignKeyConstraint(self::EVENT, [self::FIELD_EVENT_ID], ['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::EVENTS_SPEAKERS);

        $schema->dropTable(self::EVENTS_ORGANIZATIONS);

        $tableSchedule = $schema->getTable(self::SCHEDULE);
        $tableSchedule->dropColumn(self::FIELD_EVENT_ID);
    }
}
