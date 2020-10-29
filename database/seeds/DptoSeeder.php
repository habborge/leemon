<?php

use Illuminate\Database\Seeder;
use App\Department;

class DptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dpto = [
            1 => ['ANTIOQUIA', 5],
            2 => ['ATLÁNTICO', 8],
            3 => ['BOGOTÁ, D.C.', 11],
            4 => ['BOLÍVAR', 13],
            5 => ['BOYACÁ', 15],
            6 => ['CALDAS', 17],
            7 => ['CAQUETÁ', 18],
            8 => ['CAUCA', 19],
            9 => ['CESAR', 20],
            10 => ['CÓRDOBA', 23],
            11 => ['CUNDINAMARCA', 25],
            12 => ['CHOCÓ', 27],
            13 => ['HUILA', 41],
            14 => ['LA GUAJIRA', 44],
            15 => ['MAGDALENA', 47],
            16 => ['META', 50],
            17 => ['NARIÑO', 52],
            18 => ['NORTE DE SANTANDER', 54],
            19 => ['QUINDIO', 63],
            20 => ['RISARALDA', 66],
            21 => ['SANTANDER', 68],
            22 => ['SUCRE', 70],
            23 => ['TOLIMA', 73],
            24 => ['VALLE DEL CAUCA', 76],
            25 => ['ARAUCA', 81],
            26 => ['CASANARE', 85],
            27 => ['PUTUMAYO', 86],
            28 => ['ARCHIPIÉLAGO DE SAN ANDRÉS, PROVIDENCIA Y SANTA CATALINA', 88],
            29 => ['AMAZONAS', 91],
            30 => ['GUAINÍA', 94],
            31 => ['GUAVIARE', 95],
            32 => ['VAUPÉS', 97],
            33 => ['VICHADA', 99],
        ];

        for ($i = 1; $i <= 33; $i++){
            if ($dpto[$i][0] != ''){
                Department::create([
                'id' => $i,
                'department' => $dpto[$i][0],
                'code' => $dpto[$i][1]
                ]);
            }
            
        }
    }
}
