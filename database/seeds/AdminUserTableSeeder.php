<?php

use Illuminate\Database\Seeder;
use App\User;
class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'username' => 'habiware',
            'email' => 'habiware@designware.com.co',
            'password' => Hash::make('adminadmin'),
            'level_access' => '0',
        ]);
    }
}
