<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRoles;

class UserRoleInsert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRoles::truncate();

        UserRoles::insert([
            ['name' => 'admin',],
            ['name' => 'regular',]
        ]);
    }
}
