<?php

namespace App\Http\Controllers\Concerns;

use App\Models\User;
use Illuminate\Support\Str;

trait GeneratesUniqueUsername
{
    private function generateUniqueUsernameFromEmail(string $email, ?int $ignoreUserId = null): string
    {
        $base = Str::slug(Str::before($email, '@'), '_');
        $base = $base !== '' ? $base : 'user';
        $username = $base;
        $counter = 1;

        while (
            User::query()
                ->when($ignoreUserId, fn($query) => $query->where('id', '!=', $ignoreUserId))
                ->where('username', $username)
                ->exists()
        ) {
            $username = $base . '_' . $counter;
            $counter++;
        }

        return $username;
    }
}
