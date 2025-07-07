<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Supply;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // super admin
        $super = User::factory()->create([
            'name' => 'Super User',
            'email' => 'super@example.com',
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $issueance = User::factory()->create([
            'name' => 'Issuenace User',
            'email' => 'issuenace@example.com',
        ]);

        $user = User::factory()->create([
            'name' => 'Employee',
            'email' => 'user@example.com',
        ]);

        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $super->assignRole('super-admin');

        $admin->assignRole('admin');
        $issueance->assignRole('admin');

        $user->assignRole('user');

        Supply::create([
            'item_description' => 'Alcohol 500ml',
            'category' => 'Supplies',
            'unit' => 'bottle'
        ]);
        Supply::create([
            'item_description' => 'Alcohol 100ml',
            'category' => 'Supplies',
            'unit' => 'bottle'
        ]);
        Supply::create([
            'item_description' => 'Alcohol 50ml',
            'category' => 'Supplies',
            'unit' => 'bottle'
        ]);
    }
}
