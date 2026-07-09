<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@sims.com',
            'password' => Hash::make('admin123'), // WAJIB di-hash!
        ]);

        $this->command->info('UserSeeder: Akun admin berhasil dibuat.');
        $this->command->info('Login: admin@sims.com | admin123');
    }
}
