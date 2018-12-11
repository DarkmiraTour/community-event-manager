<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\Type;

final class Version20181121130537 extends AbstractMigration
{
    private const TABLE_NAME = 'app_user';

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::TABLE_NAME);
        $table->addColumn('id', Type::GUID);
        $table->addColumn('email', Type::STRING, ['length' => 320]);
        $table->addColumn('username', Type::STRING, ['length' => 50]);
        $table->addColumn('roles', Type::JSON);
        $table->addColumn('password', Type::STRING, ['length' => 320]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['email']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::TABLE_NAME);
    }
}
