<?php

namespace Database\Seeders;

use App\Models\UserRoles;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminInsert extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'user_role_id' => UserRoles::where('name', 'admin')->first()->id,
            'password' => Hash::make(123456789),
        ]);
    }
}
