<?php

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('users')->insertGetId([
            'user' => "luis.pineda",
            'email' => "luis.pineda@ceindetec.org.co",
            'password' => bcrypt('123'),
            'activado'=>'S',
            'rol' => "superAdmin",
            'avatar' => "avatar4.png",
        ]);
        DB::table('personas')->insert([
            'identificacion' => "1120456789",
            'user_id'=> $id,
            'nombres' => "Luis Carlos Pineda",
            'telefono' => "7788996",
            'id_municipio' => "756",
            'sexo' => "M",
            'fecha_nacimiento' => NULL,
        ]);

    }
}
