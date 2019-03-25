<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20190321102134 extends AbstractMigration
{
    private const TABLE_NAME = 'events';

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', Type::GUID);
        $table->addColumn('name', Type::STRING, ['length' => 100]);
        $table->addColumn('description', Type::TEXT, ['notnull' => false]);
        $table->addColumn('address_id', Type::GUID);
        $table->addColumn('start_at', Type::DATETIME);
        $table->addColumn('end_at', Type::DATETIME);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE_NAME);
    }
}
