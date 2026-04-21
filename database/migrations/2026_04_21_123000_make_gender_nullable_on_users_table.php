<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY gender ENUM('male','female') NULL");

        if (!$this->hasEmailUniqueIndex()) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('email');
            });
        }
    }

    public function down(): void
    {
        if ($this->hasEmailUniqueIndex()) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_email_unique');
            });
        }

        DB::statement("ALTER TABLE users MODIFY gender ENUM('male','female') NOT NULL");
    }

    private function hasEmailUniqueIndex(): bool
    {
        $database = DB::getDatabaseName();
        $index = DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', 'users')
            ->where('index_name', 'users_email_unique')
            ->exists();

        return $index;
    }
};
