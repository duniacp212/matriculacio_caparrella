<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Usuari;
use Ramsey\Uuid\Uuid;

class UsuariModel extends Model
{
    protected $table = 'usuari';
    protected $primaryKey = 'id_usuari';
    protected $returnType = Usuari::class;
    protected $useAutoIncrement = false;

    protected $useTimestamps = true;
    protected $createdField = 'creat_el';
    protected $updatedField = 'actualitzat_el';

    protected $allowedFields = [
        'id_usuari',
        'nom',
        'cognom1',
        'cognom2',
        'dni_nie',
        'usuari',
        'password',
        'email',
        'telefon',
        'rol',
        'secret_2fa',
        'te_2fa'
    ];

    protected $validationRules = [
        'nom' => 'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
        'cognom1' => 'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
        'cognom2' => 'permit_empty|max_length[100]|regex_match[/^[a-zA-ZáéíóúàèìòùäëïöüñçÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÑÇ\·\-\'\s]+$/u]',
        'dni_nie' => 'required|max_length[20]|is_unique[usuari.dni_nie]|dni_nie_valid',
        'email' => 'required|valid_email|is_unique[usuari.email]|max_length[150]',
        'telefon' => 'permit_empty|regex_match[/^(\+?[0-9]{9,15})$/]',
        'rol' => 'required|in_list[super admin,administracio,secretaria]',
        'password' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/]',
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'El nom és obligatori.',
            'min_length' => 'El nom ha de tenir almenys 2 caràcters.',
            'max_length' => 'El nom no pot superar els 100 caràcters.',
            'regex_match' => 'El nom només pot contenir lletres, espais, guions o apòstrofs.'
        ],
        'cognom1' => [
            'required' => 'El primer cognom és obligatori.',
            'min_length' => 'El primer cognom ha de tenir almenys 2 caràcters.',
            'max_length' => 'El primer cognom no pot superar els 100 caràcters.',
            'regex_match' => 'El primer cognom només pot contenir lletres, espais, guions o apòstrofs.'
        ],
        'cognom2' => [
            'max_length' => 'El segon cognom no pot superar els 100 caràcters.',
            'regex_match' => 'El segon cognom només pot contenir lletres, espais, guions o apòstrofs.'
        ],
        'dni_nie' => [
            'required' => 'El DNI/NIE és obligatori.',
            'max_length' => 'El DNI/NIE no pot superar els 20 caràcters.',
            'is_unique' => 'Aquest DNI/NIE ja està registrat a la base de dades.'
        ],
        'email' => [
            'required' => 'El correu electrònic és obligatori.',
            'valid_email' => 'El format del correu electrònic no és vàlid.',
            'is_unique' => 'Aquest correu electrònic ja està registrat per un altre usuari.',
            'max_length' => 'El correu electrònic no pot superar els 150 caràcters.'
        ],
        'telefon' => [
            'regex_match' => 'El format del telèfon no és vàlid.'
        ],
        'rol' => [
            'required' => 'El rol és obligatori.',
            'in_list' => 'El rol seleccionat no és vàlid.'
        ],
        'password' => [
            'required' => 'La contrasenya és obligatòria.',
            'regex_match' => 'La contrasenya ha de contenir almenys una majúscula, un número i un símbol.',
            'min_length' => 'La contrasenya ha de tenir almenys 8 caràcters.'
        ]
    ];

    protected $beforeInsert = ['generateUuidV7'];

    public function actualitzarUsuari($id, $dades)
    {
        $reglesActualitzades = $this->validationRules;
        $reglesActualitzades['dni_nie'] = 'required|max_length[20]|is_unique[usuari.dni_nie,id_usuari,' . $id . ']|dni_nie_valid';
        $reglesActualitzades['email'] = 'required|valid_email|is_unique[usuari.email,id_usuari,' . $id . ']|max_length[150]';

        if (empty($dades['password'])) {
            unset($reglesActualitzades['password']);
        }

        $this->setValidationRules($reglesActualitzades);
        return $this->update($id, $dades);
    }

    protected function generateUuidV7(array $data)
    {
        if (!isset($data['data']['id_usuari'])) {
            $uuid = Uuid::uuid7();
            $data['data']['id_usuari'] = $uuid->getBytes();
        }

        return $data;
    }
}