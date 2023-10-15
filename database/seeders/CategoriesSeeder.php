<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'id' => Str::uuid()->toString(),
            'name' => 'newest',
        ]);

        Category::create([
            'id' => Str::uuid()->toString(),
            'name' => 'regular',
        ]);

        Category::create([
            'id' => Str::uuid()->toString(),
            'name' => 'discount',
        ]);
    }
}
