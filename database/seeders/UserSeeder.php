<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Models\Role as ModelsRole;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the user
        $admin = new User();
        $admin->name = "admin";
        $admin->number = "0938091493";
        $admin->password = Hash::make("123123123");

        // Assign the existing role to the user
        $adminRole = ModelsRole::where('name', 'admin')->first();
        $admin->assignRole($adminRole);

        // Save the user
        $admin->save();
    }
}
