<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // Permissions
        //company related 
        Permission::create(['name' => 'create company']);
        Permission::create(['name' => 'delete company']);
        Permission::create(['name' => 'edit company']);
        Permission::create(['name' => 'edit company situation']);

        //user related
        Permission::create(['name' => 'see user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'edit user']);

        //internships offers related
        Permission::create(['name' => 'create offer']);
        Permission::create(['name' => 'delete offer']);
        Permission::create(['name' => 'edit offer']);

        //applications related
        Permission::create(['name' => 'send application']);
        Permission::create(['name' => 'accept application']);


        // Roles
        //student role creation and permissions
        $student = Role::create(['name' => 'student']);
        $student->givePermissionTo(['send application']);
        $user_student = \App\Models\User::factory()->create([
            'name' => 'Student 1',
            'email' => 'student@gmail.com',
            'password' => Hash::make('student123')
        ]);
        $user_student->assignRole($student);

        //coordinator role creation and permissions
        $coordinator = Role::create(['name' => 'coordinator']);
        $coordinator->givePermissionTo(['create company','delete company','edit company','edit company situation',
                                        'see user','create user','delete user','edit user',
                                        'create offer','delete offer','edit offer',
                                        'accept application']);
        $user_coordinator = \App\Models\User::factory()->create([
            'name' => 'Coordinator 1',
            'email' => 'coordinator@gmail.com',
            'password' => Hash::make('coordinator123')
        ]);
        $user_coordinator->assignRole($coordinator);

        //super-admin role creation
        $super_admin = Role::create(['name' => 'super_admin']);
        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('admin123')
        ]);
        $user->assignRole($super_admin);
    }
}
