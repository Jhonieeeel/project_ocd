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
            'name' => 'Dave Madayag',
            'email' => 'super@example.com',
            'division' => 'AFMS',
            'office' => 'GASU',
            'position' => 'Head',
        ]);

        $admin = User::factory()->create([
            'name' => 'Maam Mar',
            'email' => 'admin@example.com',
            'division' => 'AFMS',
            'office' => '',
            'position' => "Head"
        ]);

        $admin2 = User::factory()->create([
            'name' => 'Sir Ray',
            'email' => 'issuenace@example.com',
            'division' => 'AFMS',
            'office' => 'GASU',
        ]);

        $admin3 = User::factory()->create([
            'name' => 'Sir Rocky',
            'email' => 'rocky@example.com',
            'division' => 'AFMS',
            'office' => 'GASU',
        ]);

        $admin4 = User::factory()->create([
            'name' => 'Sir Carilito',
            'email' => 'carlito@example.com',
            'division' => 'AFMS',
            'office' => 'RMU'
        ]);

        $user = User::factory()->create([
            'name' => 'Mike Alsong',
            'email' => 'user@example.com',
            'division' => 'AFMS',
            'office' => 'RMU',
            'position' => 'GIP'
        ]);

        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'issueance']);
        Role::create(['name' => 'user']);

        $super->assignRole('super-admin');

        $admin->assignRole('admin');
        $admin2->assignRole('admin');
        $admin3->assignRole('admin');
        $admin4->assignRole('admin');
        $admin2->assignRole('issueance');

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
