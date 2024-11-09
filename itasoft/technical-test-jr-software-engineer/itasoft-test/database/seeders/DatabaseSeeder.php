<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminUser = User::factory()->create([
            'name' => 'Admin Itasoft',
            'email' => 'admin@itasoft.com',
        ]);
        $adminUser->assignRole('admin');

        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        

        $customerUser = User::factory()->create([
            'name' => 'M Azfa Asykarulloh',
            'email' => 'mazfaa@gmail.com',
        ]);
        $customerUser->assignRole('customer');

        $tesla = User::factory()->create([
            'name' => 'Nikola Tesla',
            'email' => 'nikolatesla@gmail.com',
        ]);
        $tesla->assignRole('customer');

        $newton = User::factory()->create([
            'name' => 'Sir Isaac Newton',
            'email' => 'isaacnewton@gmail.com',
        ]);
        $newton->assignRole('customer');

        $this->call([
            ProductSeeder::class,
            PermissionTableSeeder::class,
            TransactionSeeder::class,
            TransactionDetailSeeder::class,
        ]);
        
        $adminPermissions = Permission::pluck('name')->all();
        $adminRole->syncPermissions($adminPermissions);

        $customerPermissions = Permission::whereIn('name', ['list-transaction', 'create-transaction', 'list-product'])->pluck('name')->all();
        $customerRole->syncPermissions($customerPermissions);
    }
}
