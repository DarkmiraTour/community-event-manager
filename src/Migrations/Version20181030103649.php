<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181030103649 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('organisation');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('name', Type::STRING, ['length' => 255]);
        $table->addColumn('website', Type::STRING, ['length' => 255]);
        $table->addColumn('address', Type::STRING, ['length' => 255, 'notnull' => false]);
        $table->addColumn('comment', Type::TEXT, ['notnull' => false]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('organisation')) {
            $schema->dropTable('organisation');
        }
    }
}
