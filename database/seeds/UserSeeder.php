<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\User();
        $admin->firstName = 'Admin';
        $admin->surname = 'Admin';
        $admin->username = 'admin';
        $admin->email = 'admin@admin.com';
        $admin->email_verified_at = '2020-11-16 00:00:00';
        $admin->password = bcrypt('haslohaslo');
        $admin->email = 'admin@admin.com';
        $admin->tokens = 0;
        $admin->save();
    }
}
