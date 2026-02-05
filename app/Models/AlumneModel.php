<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumneModel extends Model
{
    protected $table = 'alumnes';
    protected $primaryKey = 'id_alumne';

    protected $allowedFields = [
        'nom',
        'cognoms',
        'dni',
        'data_naixement',
        'email',
        'telefon'
    ];
}
