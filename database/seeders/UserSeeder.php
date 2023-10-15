<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => Str::uuid()->toString(),
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'id' => Str::uuid()->toString(),
            'first_name' => 'employee',
            'last_name' => 'employee',
            'email' => 'employee@employee.com',
            'password' => Hash::make('employee123'),
        ]);

        User::create([
            'id' => Str::uuid()->toString(),
            'first_name' => 'client',
            'last_name' => 'client',
            'email' => 'client@client.com',
            'password' => Hash::make('client123'),
        ]);
    }
}
