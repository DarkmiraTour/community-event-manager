<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20190306091949 extends AbstractMigration
{
    private const SLOT_TABLE_NAME = 'slot';

    public function up(Schema $schema): void
    {
        $table = $schema->getTable(self::SLOT_TABLE_NAME);
        $table->addColumn('talk_id', Type::GUID, ['notnull' => false]);
        $table->addIndex(['talk_id']);
        $table->addForeignKeyConstraint('talk', ['talk_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable(self::SLOT_TABLE_NAME);

        foreach ($table->getIndexes() as $index) {
            if (in_array('talk_id', $index->getColumns())) {
                $table->dropIndex($index->getName());
                break;
            }
        }

        $table->dropColumn('talk_id');
    }
}
