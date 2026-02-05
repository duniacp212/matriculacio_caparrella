<?php

namespace App\Models;

use CodeIgniter\Model;

class MatriculaModel extends Model
{
    protected $table = 'matricules';
    protected $primaryKey = 'id_matricula';

    protected $allowedFields = [
        'id_alumne',
        'any_matricula',
        'estudi',
        'curs',
        'familia',
        'cicle',
        'estat',
        'pagament'
    ];
}
