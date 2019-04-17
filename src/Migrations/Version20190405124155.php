<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Migrations\AbstractTableNameMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

final class Version20190405124155 extends AbstractTableNameMigration
{
    public function up(Schema $schema): void
    {
        $this->checkDatabase();

        $schema->createSequence('speaker_event_interview_sent_id_seq');

        $table = $schema->createTable(self::SPEAKER_EVENT_INTERVIEW_SENT);
        $table->addColumn('id', Type::INTEGER, ['default' => null]);
        $table->addColumn('speaker_id', Type::GUID, ['notnull' => false]);
        $table->addColumn('event_id', Type::GUID, ['notnull' => false]);
        $table->addColumn('interview_sent', Type::BOOLEAN);
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint(self::SPEAKER, ['speaker_id'], ['id']);
        $table->addForeignKeyConstraint(self::EVENT, ['event_id'], ['id']);
        $table->addIndex(['speaker_id']);
        $table->addIndex(['event_id']);

        $table = $schema->getTable(self::SPEAKER);
        $table->dropColumn('interview_sent');
    }

    public function down(Schema $schema): void
    {
        $this->checkDatabase();

        $schema->dropSequence('speaker_event_interview_sent_id_seq');

        $schema->dropTable(self::SPEAKER_EVENT_INTERVIEW_SENT);

        $table = $schema->getTable(self::SPEAKER);
        $table->addColumn('interview_sent', Type::BOOLEAN);
    }
}
