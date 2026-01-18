<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'cino@gmail.com'],
            [
                'first_name' => 'Helis',
                'last_name' => 'cino',
                'name' => 'Helis cino',
                'password' => Hash::make('password123'),
                'role' => 'agent',
                'contact' => '22892998681',
                'address' => 'Lomé, Togo',
                'birth_date' => '2002-12-11',
                'gender' => 'male',
                'nationality' => 'togolaise',
            ]
        );

        $this->command->info('✅ Agent créé avec succès!');
        $this->command->info('📧 Email: cino@gmail.com');
        $this->command->info('🔑 Mot de passe: password123');
    }
}