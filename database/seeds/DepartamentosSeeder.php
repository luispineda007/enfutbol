<?php

use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departamentos')->insert([
            ['id'=>"1" , 'departamento'=>'AMAZONAS'],
            ['id'=>"2" , 'departamento'=>'ANTIOQUIA'],
            ['id'=>"3" , 'departamento'=>'ARAUCA'],
            ['id'=>"4" , 'departamento'=>'ATLÁNTICO'],
            ['id'=>"5" , 'departamento'=>'BOLÍVAR'],
            ['id'=>"6" , 'departamento'=>'BOYACÁ'],
            ['id'=>"7" , 'departamento'=>'CALDAS'],
            ['id'=>"8" , 'departamento'=>'CAQUETÁ'],
            ['id'=>"9" , 'departamento'=>'CASANARE'],
            ['id'=>"10", 'departamento'=>'CAUCA'],
            ['id'=>"11", 'departamento'=>'CESAR'],
            ['id'=>"12", 'departamento'=>'CHOCÓ'],
            ['id'=>"13", 'departamento'=>'CÓRDOBA'],
            ['id'=>"14", 'departamento'=>'CUNDINAMARCA'],
            ['id'=>"15", 'departamento'=>'GUAINÍA'],
            ['id'=>"16", 'departamento'=>'GUAVIARE'],
            ['id'=>"17", 'departamento'=>'HUILA'],
            ['id'=>"18", 'departamento'=>'LA GUAJIRA'],
            ['id'=>"19", 'departamento'=>'MAGDALENA'],
            ['id'=>"20", 'departamento'=>'META'],
            ['id'=>"21", 'departamento'=>'NARIÑO'],
            ['id'=>"22", 'departamento'=>'NORTE DE SANTANDER'],
            ['id'=>"23", 'departamento'=>'PUTUMAYO'],
            ['id'=>"24", 'departamento'=>'QUINDÍO'],
            ['id'=>"25", 'departamento'=>'RISARALDA'],
            ['id'=>"26", 'departamento'=>'SAN ANDRÉS Y ROVIDENCIA'],
            ['id'=>"27", 'departamento'=>'SANTANDER'],
            ['id'=>"28", 'departamento'=>'SUCRE'],
            ['id'=>"29", 'departamento'=>'TOLIMA'],
            ['id'=>"30", 'departamento'=>'VALLE DEL CAUCA'],
            ['id'=>"31", 'departamento'=>'VAUPÉS'],
            ['id'=>"32", 'departamento'=>'VICHADA'],
            ['id'=>"33", 'departamento'=>'SIN DEPARTAMENTO']
        ]);
    }
}
