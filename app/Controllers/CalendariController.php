<?php

namespace App\Controllers;

use App\Models\TascaModel;

class CalendariController extends BaseController
{
    public function index()
    {
        return view('calendari/index', [
            'title' => 'Calendari'
        ]);
    }

    public function events()
    {
        $model   = new TascaModel();
        $tasques = $model->findAll();

        $events = [];
        foreach ($tasques as $tasca) {
            $events[] = [
                'id'          => $tasca['id_tasca'],
                'title'       => $tasca['titol'],
                'start'       => $tasca['data'] . 'T' . substr($tasca['creat_el'], 11, 5),
                'description' => $tasca['descripcio'] ?? '',
                'createdAt'   => $tasca['creat_el'],
            ];
        }

        return $this->response->setJSON($events);
    }

    public function guardar()
    {
        $model = new TascaModel();

        $model->insert([
            'titol'      => $this->request->getPost('titol'),
            'descripcio' => $this->request->getPost('descripcio'),
            'data'       => $this->request->getPost('data'),
        ]);

        return $this->response->setJSON(['ok' => true]);
    }

    public function eliminar($id)
    {
        $id    = (int) $id;
        $model = new TascaModel();
        $model->delete($id);

        return $this->response->setJSON(['ok' => true]);
    }
}