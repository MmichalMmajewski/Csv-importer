<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'givenname' => 'Jan',
            'surname' => 'Kowalski',
            'username' => 'jKowal',
        ]);
    }
}
