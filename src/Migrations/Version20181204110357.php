<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

final class Version20181204110357 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->createTableAddress($schema);
        $this->createTableContact($schema);
        $this->createTableContactAddress($schema);
        $this->modifyTableOrganisation($schema);
    }

    private function createTableAddress(Schema $schema): void
    {
        $schema->createSequence('address_id_seq');

        $table = $schema->createTable('address');
        $table->addColumn('id', Type::GUID);
        $table->addColumn('name', Type::STRING, ['length' => 63]);
        $table->addColumn('street_address', Type::STRING, ['length' => 127]);
        $table->addColumn('street_address_complementary', Type::STRING, ['notnull' => false, 'length' => 127]);
        $table->addColumn('postal_code', Type::STRING, ['length' => 15]);
        $table->addColumn('city', Type::STRING, ['length' => 63]);

        $table->setPrimaryKey(['id']);
    }

    private function createTableContact(Schema $schema): void
    {
        $schema->createSequence('contact_id_seq');

        $table = $schema->createTable('contact');

        $table->addColumn('id', Type::GUID);
        $table->addColumn('first_name', Type::STRING, ['length' => 63]);
        $table->addColumn('last_name', Type::STRING, ['length' => 63]);
        $table->addColumn('email', Type::STRING, ['notnull' => false, 'length' => 255]);
        $table->addColumn('phone_number', Type::STRING, ['length' => 31, 'notnull' => false]);

        $table->setPrimaryKey(['id']);
    }

    private function createTableContactAddress(Schema $schema): void
    {
        $table = $schema->createTable('contact_address');

        $table->addColumn('contact_id', Type::GUID);
        $table->addColumn('address_id', Type::GUID);

        $table->setPrimaryKey(['contact_id', 'address_id']);

        $table->addForeignKeyConstraint('contact', ['contact_id'], ['id'], ['onDelete' => 'CASCADE']);
        $table->addForeignKeyConstraint('address', ['address_id'], ['id'], ['onDelete' => 'CASCADE']);
    }

    private function modifyTableOrganisation(Schema $schema): void
    {
        $table = $schema->getTable('organisation');

        $table->dropColumn('address');

        $table->addColumn('contact_id', Type::GUID, ['notnull' => false]);
        $table->addIndex(['contact_id']);
        $table->addForeignKeyConstraint('contact', ['contact_id'], ['id']);
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('address')) {
            $schema->dropTable('address');
            $schema->dropSequence('address_id_seq');
        }

        if ($schema->hasTable('contact')) {
            $schema->dropTable('contact');
            $schema->dropSequence('contact_id_seq');
        }

        if ($schema->hasTable('contact_address')) {
            $schema->dropTable('contact_address');
        }

        $organisationTable = $schema->getTable('organisation');
        $organisationTable->addColumn('address', Type::STRING, ['length' => 255, 'notnull' => false]);
        $organisationTable->dropColumn('contact_id');
    }
}
