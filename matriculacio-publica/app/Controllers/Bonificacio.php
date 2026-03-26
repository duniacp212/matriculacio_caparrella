<?php

namespace App\Controllers;

use App\Models\BonificacioModel;
use CodeIgniter\Controller;

class Bonificacio extends Controller
{
    public function index()
    {
        $model = new BonificacioModel();
        $data['bonificacions'] = $model->findAll();
        return view('formsviews/bonificacio', $data);
    }

    public function guardar()
    {
        $request = service('request');

        $seleccionades = $request->getPost('bonificacions');
        $files         = $request->getFiles();
        $resultat      = [];

        if ($seleccionades) {
            foreach ($seleccionades as $id) {
                $file      = $files['documents'][$id] ?? null;
                $nomFitxer = null;

                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $nomFitxer = $file->getRandomName();
                    $file->move(WRITEPATH . 'uploads', $nomFitxer);
                }

                $resultat[] = [
                    'bonificacio_id' => $id,
                    'document'       => $nomFitxer,
                ];
            }
        }

        // TODO: guardar a matricula_bonificacio quan estigui implementat
        return redirect()->to(base_url('forms/confirmacio'));
    }
}