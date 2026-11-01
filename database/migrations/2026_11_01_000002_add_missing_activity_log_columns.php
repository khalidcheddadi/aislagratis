<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $schema = Schema::connection(config('activitylog.database_connection'));
        $tableName = config('activitylog.table_name');

        if (! $schema->hasTable($tableName)) {
            throw new RuntimeException("The activity log table [{$tableName}] does not exist.");
        }

        if (! $schema->hasColumn($tableName, 'event')) {
            $schema->table($tableName, function (Blueprint $table) {
                $table->string('event')->nullable()->after('subject_type');
            });
        }

        if (! $schema->hasColumn($tableName, 'batch_uuid')) {
            $schema->table($tableName, function (Blueprint $table) {
                $table->uuid('batch_uuid')->nullable()->after('properties');
            });
        }
    }

    public function down(): void
    {
        $schema = Schema::connection(config('activitylog.database_connection'));
        $tableName = config('activitylog.table_name');

        if (! $schema->hasTable($tableName)) {
            return;
        }

        $columns = array_values(array_filter(
            ['event', 'batch_uuid'],
            fn (string $column): bool => $schema->hasColumn($tableName, $column),
        ));

        if ($columns !== []) {
            $schema->table($tableName, function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
