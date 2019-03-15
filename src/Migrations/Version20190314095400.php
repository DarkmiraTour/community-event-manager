<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20190314095400 extends AbstractMigration
{
    private const INTERVIEW_QUESTION_TABLE_NAME = 'interview_question';

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(self::INTERVIEW_QUESTION_TABLE_NAME);
        $table->addColumn('id', Type::GUID);
        $table->addColumn('question', Type::STRING, ['length' => 255]);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(self::INTERVIEW_QUESTION_TABLE_NAME);
    }
}
