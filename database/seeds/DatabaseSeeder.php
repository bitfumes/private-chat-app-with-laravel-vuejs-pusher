<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(User::class)->create(
            [
                'email' => 'sarthak@gmail.com',
                'name' => 'Sarthak'
            ]
        );
        factory(User::class)->create(
            [
                'email' => 'bitfumes@gmail.com',
                'name' => 'Bitfumes'
            ]
        );
        factory(User::class)->create(
            [
                'email' => 'ankur@gmail.com',
                'name' => 'Ankur'
            ]
        );
    }
}
