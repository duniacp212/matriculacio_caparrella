<?php

namespace App\Controllers;

use App\Models\AlumneModel;
use App\Models\MatriculaModel;

class AlumnesController extends BaseController
{
    public function index()
    {
        $request = service('request');

        $filtres = [
            'any'          => $request->getGet('any'),
            'estudi'       => $request->getGet('estudi'),
            'curs'         => $request->getGet('curs'),
            'familia'      => $request->getGet('familia'),
            'cicle'        => $request->getGet('cicle'),
            'estat'        => $request->getGet('estat'),
            'pagament'     => $request->getGet('pagament'),
            'bonificats'  => $request->getGet('bonificacio'),
        ];


        $db = db_connect();

        $builder = $db->table('alumnes');
        $builder->select([
            'alumnes.id_alumne',
            'alumnes.nom',
            'alumnes.cognoms',
            'alumnes.dni',
            'matricules.any_matricula',
            'matricules.estudi',
            'matricules.curs',
            'matricules.familia',
            'matricules.cicle',
            'matricules.estat',
            'matricules.pagament',
            'matricules.bonificats'
        ]);

        $builder->join(
            'matricules',
            'matricules.id_alumne = alumnes.id_alumne',
            'left'
        );

        if ($filtres['any']) {
            $builder->where('matricules.any_matricula', $filtres['any']);
        }
        if ($filtres['estudi']) {
            $builder->where('matricules.estudi', $filtres['estudi']);
        }
        if ($filtres['curs']) {
            $builder->where('matricules.curs', $filtres['curs']);
        }
        if ($filtres['familia']) {
            $builder->where('matricules.familia', $filtres['familia']);
        }
        if ($filtres['cicle']) {
            $builder->where('matricules.cicle', $filtres['cicle']);
        }
        if ($filtres['estat']) {
            $builder->where('matricules.estat', $filtres['estat']);
        }
        if (!empty($filtres['pagament'])) {
            $builder->where('matricules.pagament', $filtres['pagament']);
        }
        if ($filtres['bonificats'] !== null && $filtres['bonificats'] !== '') {
            $builder->where('matricules.bonificats', $filtres['bonificats']);
        }

        $alumnes = $builder->get()->getResultArray();

        return view('alumnes/index', [
            'title'   => 'Alumnes / Expedients',
            'alumnes' => $alumnes,
            'filtres' => $filtres
        ]);
    }
    public function contacte(int $id)
    {
        $db = db_connect();

        $builder = $db->table('alumnes');
        $builder->select('
        alumnes.id_alumne,
        alumnes.nom,
        alumnes.cognoms,
        alumnes.dni,
        alumnes.email,
        alumnes.telefon,
        matricules.estudi,
        matricules.curs
    ');
        $builder->join(
            'matricules',
            'matricules.id_alumne = alumnes.id_alumne',
            'left'
        );
        $builder->where('alumnes.id_alumne', $id);

        $alumne = $builder->get()->getRowArray();

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        return view('alumnes/contacte', [
            'title'  => 'Contacte alumne',
            'alumne' => $alumne
        ]);
    }

    public function expedient(int $id)
    {
        $db = db_connect();

        $builder = $db->table('alumnes');
        $builder->select('
        alumnes.id_alumne,
        alumnes.nom,
        alumnes.cognoms,
        alumnes.dni,
        alumnes.data_naixement,
        alumnes.email,
        alumnes.telefon,
        matricules.any_matricula,
        matricules.estudi,
        matricules.curs,
        matricules.familia,
        matricules.cicle,
        matricules.estat,
        matricules.pagament
    ');
        $builder->join(
            'matricules',
            'matricules.id_alumne = alumnes.id_alumne',
            'left'
        );
        $builder->where('alumnes.id_alumne', $id);

        $alumne = $builder->get()->getRowArray();

        if (!$alumne) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Alumne no trobat');
        }

        return view('alumnes/expedient', [
            'title'  => 'Expedient de l’alumne',
            'alumne' => $alumne
        ]);
    }
}
