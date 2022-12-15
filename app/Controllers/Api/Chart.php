<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use App\Controllers\BaseController;

class Chart extends BaseController
{
    use ResponseTrait;

    public function anggaran()
    {
        $response = [
            [
                'label' => 'Matematika',
                'tahun' => 2022,
                'tw1' => 25,
                'tw2' => 50,
                'tw3' => 75,
                'tw4' => 95,
            ],
            [
                'label' => 'Fisika',
                'tahun' => 2022,
                'tw1' => 25,
                'tw2' => 50,
                'tw3' => 75,
                'tw4' => 95,
            ],
            [
                'label' => 'Kimia',
                'tahun' => 2022,
                'tw1' => 25,
                'tw2' => 50,
                'tw3' => 75,
                'tw4' => 95,
            ],
            [
                'label' => 'Biologi',
                'tahun' => 2022,
                'tw1' => 25,
                'tw2' => 50,
                'tw3' => 75,
                'tw4' => 95,
            ],
            [
                'label' => 'Informatika',
                'tahun' => 2022,
                'tw1' => 25,
                'tw2' => 50,
                'tw3' => 75,
                'tw4' => 95,
            ],
            [
                'label' => 'Farmasi',
                'tahun' => 2022,
                'tw1' => 25,
                'tw2' => 50,
                'tw3' => 75,
                'tw4' => 95,
            ],
            [
                'label' => 'Statistika',
                'tahun' => 2022,
                'tw1' => 25,
                'tw2' => 50,
                'tw3' => 75,
                'tw4' => 95,
            ],
        ];
        return $this->respond($response);
    }
}
