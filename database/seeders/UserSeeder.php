<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SUPERADMIN_EMAIL');
        $password = env('SUPERADMIN_PASSWORD');

        if (blank($email) || blank($password)) {
            $this->command?->warn('SUPERADMIN_EMAIL dan SUPERADMIN_PASSWORD belum diisi; superadmin tidak dibuat.');

            return;
        }

        User::updateOrCreate([
            'email' => $email,
        ], [
            'name' => 'Super Admin Utama',
            'username' => Str::slug(Str::before($email, '@'), '_') ?: 'superadmin',
            'password' => Hash::make($password),
            'role' => 'admin',
            'status' => 'Aktif',
            'email_verified_at' => now(),
        ]);
    }
}
