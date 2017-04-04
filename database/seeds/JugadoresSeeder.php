<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class JugadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $i) {
            $entrada = array("male", "female");
            $genero = array_rand($entrada, 1);
            $nombre = $faker->firstName($genero);
            $apellido = $faker->lastName;
            $id = DB::table('users')->insertGetId([
                'user' => $nombre.".".$apellido,
                'email' => $nombre.".".$apellido."@ceindetec.org.co",
                'password' => bcrypt('123456789'),
                'activado' => 'S',
                'rol' => "jugador",
                'avatar' => "avatar4.png",
            ]);
            DB::table('personas')->insert([
                'identificacion' => $faker->ean8,
                'user_id' => $id,
                'nombres' => $nombre." ".$apellido,
                'telefono' => $faker->e164PhoneNumber ,
                'id_municipio' => "756",
                'sexo' => ($genero=="male")?"M":"F",
                'fecha_nacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
            ]);
        }
    }
}
