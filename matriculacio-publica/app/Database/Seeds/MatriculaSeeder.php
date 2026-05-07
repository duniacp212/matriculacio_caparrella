<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MatriculaSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('matricula')->truncate();

        $data = [
            ['id_matricula' =>  1, 'id_alumne' =>  1, 'id_estudi' =>  1, 'id_poble' => null, 'data_pagament' => '2025-06-02', 'data' => '2025-06-01', 'estat' => 'Validat',  'torn' => 1, 'observacions' => null],
            ['id_matricula' =>  2, 'id_alumne' =>  2, 'id_estudi' =>  2, 'id_poble' => null, 'data_pagament' => null,          'data' => '2025-06-01', 'estat' => 'Pendent',  'torn' => 1, 'observacions' => null],
            ['id_matricula' =>  3, 'id_alumne' =>  3, 'id_estudi' =>  3, 'id_poble' => null, 'data_pagament' => '2025-06-02', 'data' => '2025-06-01', 'estat' => 'Validat',  'torn' => 1, 'observacions' => null],
            ['id_matricula' =>  4, 'id_alumne' =>  4, 'id_estudi' =>  4, 'id_poble' => null, 'data_pagament' => null,          'data' => '2025-06-01', 'estat' => 'Pendent',  'torn' => 1, 'observacions' => null],
            ['id_matricula' =>  5, 'id_alumne' =>  5, 'id_estudi' =>  5, 'id_poble' => null, 'data_pagament' => '2025-06-02', 'data' => '2025-06-01', 'estat' => 'Validat',  'torn' => 2, 'observacions' => null],
            ['id_matricula' =>  6, 'id_alumne' =>  6, 'id_estudi' =>  6, 'id_poble' => null, 'data_pagament' => null,          'data' => '2025-06-01', 'estat' => 'Pendent',  'torn' => 2, 'observacions' => null],
            ['id_matricula' =>  7, 'id_alumne' =>  7, 'id_estudi' =>  7, 'id_poble' => null, 'data_pagament' => '2025-06-02', 'data' => '2025-06-01', 'estat' => 'Validat',  'torn' => 2, 'observacions' => null],
            ['id_matricula' =>  8, 'id_alumne' =>  8, 'id_estudi' =>  8, 'id_poble' => null, 'data_pagament' => null,          'data' => '2025-06-01', 'estat' => 'Pendent',  'torn' => 2, 'observacions' => null],
            ['id_matricula' =>  9, 'id_alumne' =>  9, 'id_estudi' =>  9, 'id_poble' => null, 'data_pagament' => '2025-06-02', 'data' => '2025-06-01', 'estat' => 'Validat',  'torn' => 3, 'observacions' => null],
            ['id_matricula' => 10, 'id_alumne' => 10, 'id_estudi' => 10, 'id_poble' => null, 'data_pagament' => null,          'data' => '2025-06-01', 'estat' => 'Pendent',  'torn' => 3, 'observacions' => null],
            ['id_matricula' => 11, 'id_alumne' => 11, 'id_estudi' => 11, 'id_poble' => null, 'data_pagament' => '2025-06-02', 'data' => '2025-06-01', 'estat' => 'Validat',  'torn' => 3, 'observacions' => null],
            ['id_matricula' => 12, 'id_alumne' => 12, 'id_estudi' => 12, 'id_poble' => null, 'data_pagament' => null,          'data' => '2025-06-01', 'estat' => 'Pendent',  'torn' => 3, 'observacions' => null],
            ['id_matricula' => 13, 'id_alumne' => 13, 'id_estudi' =>  7, 'id_poble' => null, 'data_pagament' => '2025-06-02', 'data' => '2025-06-01', 'estat' => 'Validat',  'torn' => 1, 'observacions' => null],
            ['id_matricula' => 14, 'id_alumne' => 14, 'id_estudi' =>  8, 'id_poble' => null, 'data_pagament' => null,          'data' => '2025-06-01', 'estat' => 'Pendent',  'torn' => 1, 'observacions' => null],
            ['id_matricula' => 15, 'id_alumne' => 15, 'id_estudi' =>  9, 'id_poble' => null, 'data_pagament' => '2025-06-02', 'data' => '2025-06-01', 'estat' => 'Validat',  'torn' => 2, 'observacions' => null],
        ];

        $this->db->table('matricula')->insertBatch($data);
    }
}