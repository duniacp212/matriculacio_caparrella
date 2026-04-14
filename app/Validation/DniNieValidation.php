<?php

namespace App\Validation;

class DniNieValidation
{
    public function dni_nie_valid(string $valor): bool
    {
        $valor = strtoupper(trim($valor));
        $lletres = 'TRWAGMYFPDXBNJZSQVHLCKE';

        if (preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $valor)) {
            $numero = str_replace(['X', 'Y', 'Z'], ['0', '1', '2'], $valor);
            $numero = substr($numero, 0, 8);
            $lletra = substr($valor, -1);
            return $lletra === $lletres[$numero % 23];
        }

        if (preg_match('/^[0-9]{8}[A-Z]$/', $valor)) {
            $numero = substr($valor, 0, 8);
            $lletra = substr($valor, -1);
            return $lletra === $lletres[$numero % 23];
        }

        return false;
    }
}