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
        'name'          => "Maruschka Detmers",
        'email'         => "md@mme.com",
        'identity_card' => '19621216',    // Own's
        'address'       => "Camden Town, Londres, Inglaterra, Reino Unido",
        'password'      => bcrypt('mme'),
        'phone'         => "",
        'role'          => "admin"]
      );
      User::create(
        [
        'name'          => "Liya Silver",
        'email'         => "ls@mme.com",
        'identity_card' => '19990225',
        'address'       => "San Petersburgo, Rusia",
        'password'      => bcrypt('mme'),
        'phone'         => "",
        'role'          => "doctor"]
      );
      User::create(
        [
        'name'          => "Donna Edmondson",
        'email'         => "donna.edmondson@mme.com",
        'identity_card' => '19660201',
        'address'       => "Greensboro, Carolina del Norte, Estados Unidos",
        'password'      => bcrypt('mme'),
        'phone'         => "",
        'role'          => "doctor"]
      );
      User::create(
        [
        'name'          => "Gabbie Carter",
        'email'         => "gabby.carter@mme.com",
        'identity_card' => '20000804',
        'address'       => "Austin, Texas, Estados Unidos",
        'password'      => bcrypt('mme'),
        'phone'         => "",
        'role'          => "patient"]
      );
      factory(User::class, 50)->create();
    }
}

