<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181106155324 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('talk');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('title', Type::STRING, ['length' => 255]);
        $table->addColumn('description', Type::TEXT);
        $table->addColumn('speaker_id', Type::GUID);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('talk');
    }
}
