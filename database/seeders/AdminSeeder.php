<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <-- ici la bonne importation
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'ahadzicaden@gmail.com'], // condition pour éviter les doublons
            [
                'first_name' => 'Admin',
                'last_name' => 'Principal',
                'name' => 'Admin Principal',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

    }
    // echo $user->id;
}
