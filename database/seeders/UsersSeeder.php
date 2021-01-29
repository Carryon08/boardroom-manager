<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Roberto Carreon',
            'email' => 'admin@correo.com',
            'password' => bcrypt('12345678'),
            'user_type_id' => '1',
        ]);
        DB::table('users')->insert([
            'name' => 'Juan Perez',
            'email' => 'user@correo.com',
            'password' => bcrypt('12345678'),
            'user_type_id' => '2',
        ]);
    }
}
