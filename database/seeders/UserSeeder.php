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
        $email = env('SUPERADMIN_EMAIL', 'karyamandirisejahtera.dkw@gmail.com');
        $password = env('SUPERADMIN_PASSWORD', 'kmsdukuhwaluh');

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
