<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181029125024 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $schema->createSequence('speaker_id_seq');

        $table = $schema->createTable('speaker');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('name', Type::STRING, ['length' => 255]);
        $table->addColumn('title', Type::STRING, ['length' => 5]);
        $table->addColumn('email', Type::STRING, ['length' => 255]);
        $table->addColumn('biography', Type::TEXT);
        $table->addColumn('photo', Type::STRING, ['length' => 255]);
        $table->addColumn('twitter', Type::STRING, ['length' => 255, 'notnull' => false]);
        $table->addColumn('facebook', Type::STRING, ['length' => 255, 'notnull' => false]);
        $table->addColumn('linkedin', Type::STRING, ['length' => 255, 'notnull' => false]);
        $table->addColumn('github', Type::STRING, ['length' => 255, 'notnull' => false]);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('speaker');
    }
}
