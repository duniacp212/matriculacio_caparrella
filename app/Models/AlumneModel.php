<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Alumne;
use Ramsey\Uuid\Uuid;

class AlumneModel extends Model
{
    protected $table      = 'alumne';
    protected $primaryKey = 'id_alumne';
    protected $returnType = Alumne::class;
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'id_alumne',
        'nom',
        'cognom1',
        'cognom2',
        'data_naixement',
        'telefon',
        'telefon2',
        'dni',
        'email',
        'carrer',
        'numero',
        'pis',
        'codi_postal',
        'poblacio',
        'nacionalitat',
        'lloc_naixement',
        'expedient'
    ];

    protected $beforeInsert = ['generateUuidV7'];

    protected function generateUuidV7(array $data)
    {
        if (! isset($data['data']['id_alumne'])) {
            $uuid = Uuid::uuid7();
            $data['data']['id_alumne'] = $uuid->getBytes();
        }

        return $data;
    }

    public function getAlumnesAmbMatricula(array $filtres = [], int $limit = 0, int $offset = 0)
    {
        $builder = $this->db->table('alumne a')
            ->select('
            m.id_matricula,
            a.id_alumne,
            a.nom,
            a.cognom1,
            a.cognom2,
            a.dni,
            a.data_naixement,
            YEAR(m.data) as any_matricula,
            e.tipus as estudi,
            e.nivell as curs,
            f.nom as familia,
            m.estat,
            m.data_pagament,
            m.torn,
            COALESCE(b.percentatge, 0) as bonificats
           ')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->join('familia f', 'f.id_familia = e.id_familia', 'left')
            ->join('matricula_bonificacio mb', 'mb.id_matricula = m.id_matricula', 'left')
            ->join('bonificacio b', 'b.id_bonificacio = mb.id_bonificacio', 'left');

        if (!empty($filtres['any'])) {
            $builder->where('YEAR(m.data)', $filtres['any']);
        }
        if (!empty($filtres['estudi'])) {
            $builder->where('e.tipus', $filtres['estudi']);
        }
        if (!empty($filtres['curs'])) {
            $builder->where('e.nivell', $filtres['curs']);
        }
        if (!empty($filtres['familia'])) {
            $builder->where('f.id_familia', $filtres['familia']);
        }
        if (!empty($filtres['estat'])) {
            $builder->where('m.estat', $filtres['estat']);
        }
        if (!empty($filtres['cicle'])) {
            $builder->where('e.tipus', $filtres['cicle']);
        }
        if (!empty($filtres['torn'])) {
            $builder->where('m.torn', $filtres['torn']);
        }
        if (!empty($filtres['pagament'])) {
            if ($filtres['pagament'] === 'pagat') {
                $builder->where('m.data_pagament IS NOT NULL', null, false);
            }
            if ($filtres['pagament'] === 'pendent') {
                $builder->where('m.data_pagament IS NULL', null, false);
            }
        }
        if (isset($filtres['bonificats']) && $filtres['bonificats'] !== '') {
            if ($filtres['bonificats'] === '0') {
                $builder->groupStart()
                    ->where('b.percentatge', 0)
                    ->orWhere('b.percentatge IS NULL', null, false)
                    ->groupEnd();
            } else {
                $builder->where('b.percentatge', $filtres['bonificats']);
            }
        }
        if (!empty($filtres['cerca'])) {
            $builder->groupStart()
                ->like('a.nom', $filtres['cerca'])
                ->orLike('a.cognom1', $filtres['cerca'])
                ->orLike('a.cognom2', $filtres['cerca'])
                ->orLike('a.dni', $filtres['cerca'])
                ->groupEnd();
        }

        $builder->orderBy('a.cognom1', 'ASC');

        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResult(Alumne::class);
    }

    public function countAlumnesAmbMatricula(array $filtres = []): int
    {
        $builder = $this->db->table('alumne a')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->join('familia f', 'f.id_familia = e.id_familia', 'left')
            ->join('matricula_bonificacio mb', 'mb.id_matricula = m.id_matricula', 'left')
            ->join('bonificacio b', 'b.id_bonificacio = mb.id_bonificacio', 'left');

        if (!empty($filtres['any'])) {
            $builder->where('YEAR(m.data)', $filtres['any']);
        }
        if (!empty($filtres['estudi'])) {
            $builder->where('e.tipus', $filtres['estudi']);
        }
        if (!empty($filtres['curs'])) {
            $builder->where('e.nivell', $filtres['curs']);
        }
        if (!empty($filtres['familia'])) {
            $builder->where('f.id_familia', $filtres['familia']);
        }
        if (!empty($filtres['estat'])) {
            $builder->where('m.estat', $filtres['estat']);
        }
        if (!empty($filtres['cicle'])) {
            $builder->where('e.tipus', $filtres['cicle']);
        }
        if (!empty($filtres['torn'])) {
            $builder->where('m.torn', $filtres['torn']);
        }
        if (!empty($filtres['pagament'])) {
            if ($filtres['pagament'] === 'pagat') {
                $builder->where('m.data_pagament IS NOT NULL', null, false);
            }
            if ($filtres['pagament'] === 'pendent') {
                $builder->where('m.data_pagament IS NULL', null, false);
            }
        }
        if (isset($filtres['bonificats']) && $filtres['bonificats'] !== '') {
            if ($filtres['bonificats'] === '0') {
                $builder->groupStart()
                    ->where('b.percentatge', 0)
                    ->orWhere('b.percentatge IS NULL', null, false)
                    ->groupEnd();
            } else {
                $builder->where('b.percentatge', $filtres['bonificats']);
            }
        }
        if (!empty($filtres['cerca'])) {
            $builder->groupStart()
                ->like('a.nom', $filtres['cerca'])
                ->orLike('a.cognom1', $filtres['cerca'])
                ->orLike('a.cognom2', $filtres['cerca'])
                ->orLike('a.dni', $filtres['cerca'])
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    public function getContactePerId($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        return $this->db->table('alumne a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognom1,
                a.cognom2,
                a.dni,
                a.email,
                a.telefon,
                e.tipus,
                e.nivell
            ')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->where('a.id_alumne', $binaryId)
            ->get()
            ->getFirstRow(Alumne::class);
    }

    public function getExpedientPerId($id)
    {
        $binaryId = hex2bin(str_replace('-', '', $id));
        return $this->db->table('alumne a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognom1,
                a.cognom2,
                a.dni,
                a.data_naixement,
                a.email,
                a.telefon,
                a.telefon2,
                a.carrer,
                a.numero,
                a.pis,
                a.codi_postal,
                a.poblacio,
                a.nacionalitat,
                a.lloc_naixement,
                YEAR(m.data) as any_matricula,
                e.tipus,
                e.nivell,
                m.estat,
                m.torn,
                COALESCE(b.percentatge, 0) as bonificats
            ')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->join('matricula_bonificacio mb', 'mb.id_matricula = m.id_matricula', 'left')
            ->join('bonificacio b', 'b.id_bonificacio = mb.id_bonificacio', 'left')
            ->where('a.id_alumne', $binaryId)
            ->get()
            ->getFirstRow(Alumne::class);
    }

    public function cercaGlobal($q)
    {
        return $this->db->table('alumne a')
            ->select('
                a.id_alumne,
                a.nom,
                a.cognom1,
                a.cognom2,
                a.dni,
                e.tipus,
                e.nivell,
                m.torn
            ')
            ->join('matricula m', 'm.id_alumne = a.id_alumne', 'left')
            ->join('estudi e', 'e.id_estudi = m.id_estudi', 'left')
            ->groupStart()
            ->like('a.nom', $q)
            ->orLike('a.cognom1', $q)
            ->orLike('a.cognom2', $q)
            ->orLike('a.dni', $q)
            ->groupEnd()
            ->get()
            ->getResult(Alumne::class);
    }
}