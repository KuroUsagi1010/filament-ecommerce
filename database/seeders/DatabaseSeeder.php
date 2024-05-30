<?php

namespace Database\Seeders;

use App\Enums\AccountRole;
use App\Enums\DefaultCategoryEnum;
use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'role' => AccountRole::Admin->value
        ]);

        foreach (DefaultCategoryEnum::all() as $value) {
            $user->categories()->create(['name' => $value]);
        }
    }
}
