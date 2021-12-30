<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::create(
        [
        // 'name'          => "Maruschka Detmers",
        // 'email'         => "md@mme.com",
        // 'identity_card' => '19621216',    // Own's
        'name'          => "Connie Carter",
        'email'         => "cc@mme.com",
        'identity_card' => '19881124',    // Own's
        'password'      => bcrypt('mme'),
        // 'identity_card' => '76474871', // video
        'address'       => "Camden Town, Londres, Inglaterra, Reino Unido",
        'phone'         => "",
        'role'          => "admin"]
      );
      factory(User::class, 50)->create();
    }
}

