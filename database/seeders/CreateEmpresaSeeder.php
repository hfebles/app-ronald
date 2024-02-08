<?php

namespace Database\Seeders;

use App\Models\DatosEmpresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatosEmpresa::create([
            'name_empresa' => 'INSTRUELECT MULTISERVICIOS, C.A.',
            'rif_empresa' => 'J402040385',
            'address_empresa' => 'CALLE 15 CASA NRO. 15-26 CONJUNTO RESIDENCIAL EL BOSQUE SECTOR LOS CEREZOS CAGUA ESTADO ARAGUA ZONA POSTAL 2122',
            'telefono' => '000',
            'mail' => '1@1.COM',
            'anio_fiscal' => '2024-01-01',
            'nro_correlativo' => '1'
        ]);

        DatosEmpresa::create([
            'name_empresa' => 'INSTRUELECT IMPORT, C.A.',
            'rif_empresa' => 'J412635530',
            'address_empresa' => 'CALLE LA CEIBA LOCAL PARCELA NRO 13 SECTOR SAMAN DE GUERE TURMERO ARAGUA ZONA POSTAL 2115',
            'telefono' => '000',
            'mail' => '1@1.COM',
            'anio_fiscal' => '2024-01-01',
            'nro_correlativo' => '1'
        ]);
    }
}
