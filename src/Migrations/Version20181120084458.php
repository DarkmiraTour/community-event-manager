<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181120084458 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('page');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('title', Type::STRING, ['length' => 255]);
        $table->addColumn('content', Type::TEXT);
        $table->addColumn('background', Type::STRING, ['length' => 255]);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('page');
    }
}
