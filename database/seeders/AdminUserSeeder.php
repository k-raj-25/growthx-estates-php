<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Creates first Filament user when ADMIN_EMAIL + ADMIN_PASSWORD env vars are set (e.g. PaaS without shell).
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = trim((string) config('app.admin_bootstrap.email', ''));
        $password = getenv('ADMIN_PASSWORD');
        $password = ($password !== false && $password !== '') ? (string) $password : '';
        if ($email === '' || $password === '') {
            return;
        }

        $name = (string) config('app.admin_bootstrap.name', 'Admin');

        User::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
            ]
        );
    }
}
