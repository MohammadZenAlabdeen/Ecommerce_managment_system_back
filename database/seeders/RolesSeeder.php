<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $seller = Role::create(['name' => 'seller']);
    
        $citem = Permission::create(['name' => 'create_item']);
        $citem->assignRole($admin);
    
        $cseller = Permission::create(['name' => 'create_seller']);
        $cseller->assignRole($admin);
    
        $dseller = Permission::create(['name' => 'delete_seller']);
        $dseller->assignRole($admin);
    
        $eseller = Permission::create(['name' => 'edit_seller']);
        $eseller->assignRole($admin);
    
        $ditem = Permission::create(['name' => 'delete_item']);
        $ditem->assignRole($admin);
    
        $eitem = Permission::create(['name' => 'edit_item']);
        $eitem->assignRole($admin);
    
        $edeal = Permission::create(['name' => 'edit_deal']);
        $edeal->assignRole($admin);
        $edeal->assignRole($seller);
    
        $cdeal = Permission::create(['name' => 'create_deal']);
        $cdeal->assignRole($seller);
        $cdeal->assignRole($admin);
    
        $bdeal = Permission::create(['name' => 'bad_deal']);
        $bdeal->assignRole($admin);
    
        $gdeal = Permission::create(['name' => 'good_deal']);
        $gdeal->assignRole($admin);
    
        $afitem = Permission::create(['name' => 'ask_for_item']);
        $afitem->assignRole($seller);
    
        // ... and so on
    }
}
