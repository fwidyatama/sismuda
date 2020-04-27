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
        $faker = Faker\Factory::create('id_ID');
        $roleId = App\Models\Role::all()->pluck('id')->toArray();
        $username=['koordinator1','mekanik1','logistik1','krubus1'];
        $expertness=['-','kelistrikan','-','-'];
        for ($i = 0; $i < 4; $i++) {
            App\Models\User::create([
                'name' => $faker->name,
                'id_role' => $roleId[$i],
                'username' => $username[$i],
                'email' => $faker->email,
                'expertness' =>  $expertness[$i],
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'password' => \Hash::make('password'), // password
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
