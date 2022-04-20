<?php

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public $driver;

    public function __construct()
    {
        // ENUM type has to be added to Doctrine Type Mapping and Type::addType() in order to be able to change "enum" columns:
        // $table->enum('type', [whatever])->change();
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Type::hasType('enum') ? Type::hasType('enum') : Type::addType('enum', StringType::class);

        // NEVER MIND ^^^^
        // STILL NEED TO USE VANILLA SQL :'(
        $connection = config('database.default');
        $this->driver = config("database.connections.{$connection}.driver");
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Have in mind that changing enum possible values through Schema(Doctrine) is not possible. Check:
        // https://stackoverflow.com/questions/64534892/laravel-8-migration-change-enum-values

        if ($this->driver === 'pgsql') {
            DB::transaction(function () {
                DB::statement('ALTER TABLE attributes DROP CONSTRAINT attributes_type_check');
                DB::statement("ALTER TABLE attributes ADD CONSTRAINT attributes_type_check CHECK (type in ('checkbox', 'dropdown', 'plain_text', 'country', 'option', 'other', 'number', 'date', 'text_list', 'wysiwyg'))");
            });
        } else {
            DB::statement("ALTER TABLE attributes MODIFY COLUMN type ENUM('checkbox', 'dropdown', 'plain_text', 'country', 'option', 'other', 'number', 'date', 'text_list', 'wysiwyg')");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ($this->driver === 'pgsql') {
            \DB::transaction(function () {
                DB::statement('ALTER TABLE attributes DROP CONSTRAINT attributes_type_check');
                DB::statement("ALTER TABLE attributes ADD CONSTRAINT attributes_type_check CHECK (type in ('checkbox', 'dropdown', 'plain_text', 'country', 'option', 'other', 'number'))");
            });
        } else {
            DB::statement("ALTER TABLE attributes MODIFY COLUMN type ENUM('checkbox', 'dropdown', 'plain_text', 'country', 'option', 'other', 'number')");
        }
    }
};
