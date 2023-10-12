<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Role::insert([
            ['name' => 'Administrator', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        \App\Models\User::insert([
            [
                'name' => 'Admin', 
                'email' => 'admin@admin.com', 
                'password' => bcrypt('admin'),
                'role_id' => 1,
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()],
        ]);
    }
}
