<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181109150434 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('special_benefit');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('label', Type::STRING, ['length' => 255]);
        $table->addColumn('price', Type::FLOAT);
        $table->addColumn('description', Type::TEXT);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('special_benefit');
    }
}
