<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20190313103920 extends AbstractMigration
{
    private const SPEAKER_TABLE_NAME = 'speaker';

    public function up(Schema $schema): void
    {
        $table = $schema->getTable(self::SPEAKER_TABLE_NAME);
        $table->addColumn('interview_sent', Type::BOOLEAN);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable(self::SPEAKER_TABLE_NAME);
        $table->dropColumn('interview_sent');
    }
}
