<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'email')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('email')->nullable()->after('name');
            });
        }

        if (!Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
        }

        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->after('email');
            });
        }

        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('password');
            });
        }

        if (!Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status')->default('Aktif')->after('role');
            });
        }

        if (!Schema::hasColumn('users', 'gender')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('gender')->nullable()->after('status');
            });
        }

        DB::table('users')
            ->orderBy('id')
            ->get(['id', 'email', 'username', 'role'])
            ->each(function ($user) {
                $updates = [];

                if (empty($user->email)) {
                    $base = Str::slug((string) ($user->username ?: 'user'), '_');
                    $base = $base !== '' ? $base : 'user';
                    $email = $base . '@example.local';
                    $counter = 1;

                    while (
                        DB::table('users')
                            ->where('id', '!=', $user->id)
                            ->where('email', $email)
                            ->exists()
                    ) {
                        $email = $base . $counter . '@example.local';
                        $counter++;
                    }

                    $updates['email'] = $email;
                }

                if (empty($user->username)) {
                    $sourceEmail = $updates['email'] ?? (string) $user->email;
                    $base = Str::slug(Str::before($sourceEmail, '@'), '_');
                    $base = $base !== '' ? $base : 'user';
                    $username = $base;
                    $counter = 1;

                    while (
                        DB::table('users')
                            ->where('id', '!=', $user->id)
                            ->where('username', $username)
                            ->exists()
                    ) {
                        $username = $base . '_' . $counter;
                        $counter++;
                    }

                    $updates['username'] = $username;
                }

                if (!empty($user->role)) {
                    $updates['role'] = strtolower((string) $user->role);
                }

                if ($updates !== []) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update($updates);
                }
            });

        DB::table('users')
            ->whereNull('email')
            ->orderBy('id')
            ->get(['id'])
            ->each(function ($user) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'email' => 'user' . $user->id . '@example.local',
                    ]);
            });

        DB::table('users')
            ->whereNull('role')
            ->update(['role' => 'user']);

        DB::table('users')
            ->whereNull('status')
            ->update(['status' => 'Aktif']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'gender')) {
                $table->dropColumn('gender');
            }

            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};
