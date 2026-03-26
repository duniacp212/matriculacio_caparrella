<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id_settings';
    protected $allowedFields = ['clau', 'valor'];

    public function getSettings()
    {
        $settings = $this->findAll();
        $result = [];
        foreach ($settings as $s) {
            $result[$s['clau']] = $s['valor'];
        }
        return $result;
    }
}
