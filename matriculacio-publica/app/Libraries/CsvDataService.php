<?php

namespace App\Libraries;

/**
 * CsvDataService
 *
 * Carrega i gestiona les dades d'alumnes i estudis des del CSV.
 * Substitueix les consultes a les taules `alumne`, `estudi` i `optativa`
 * de la base de dades per a les dades de referència inicials.
 *
 * Format del CSV: dni, email, nom, cognom1, cognom2, data_naixement,
 *                 telefon, direccio, estudi_tipus, estudi_nivell, assignatures
 *
 * El camp `assignatures` és una llista separada per `;`.
 */
class CsvDataService
{
    protected string $csvPath;
    protected array  $rows = [];

    public function __construct(?string $csvPath = null)
    {
        $this->csvPath = $csvPath ?? APPPATH . 'Data/alumnes.csv';
        $this->load();
    }

    // ---------------------------------------------------------------
    // Càrrega
    // ---------------------------------------------------------------

    protected function load(): void
    {
        if (!file_exists($this->csvPath)) {
            return;
        }

        $handle = fopen($this->csvPath, 'r');
        if ($handle === false) {
            return;
        }

        $headers = null;
        while (($line = fgetcsv($handle, 0, ',')) !== false) {
            if ($headers === null) {
                $headers = $line;
                continue;
            }
            if (count($line) !== count($headers)) {
                continue; // línia malformada, la saltem
            }
            $row = array_combine($headers, $line);

            // Normalitzar assignatures com a array
            $row['assignatures'] = array_filter(
                array_map('trim', explode(';', $row['assignatures'] ?? ''))
            );

            $this->rows[] = $row;
        }

        fclose($handle);
    }

    // ---------------------------------------------------------------
    // Consultes sobre alumnes
    // ---------------------------------------------------------------

    /**
     * Retorna totes les files del CSV.
     */
    public function getAllAlumnes(): array
    {
        return $this->rows;
    }

    /**
     * Cerca un alumne pel DNI (insensible a majúscules).
     */
    public function getAlumneByDni(string $dni): ?array
    {
        $dni = strtoupper(trim($dni));
        foreach ($this->rows as $row) {
            if (strtoupper($row['dni']) === $dni) {
                return $row;
            }
        }
        return null;
    }

    /**
     * Cerca un alumne pel correu electrònic.
     */
    public function getAlumneByEmail(string $email): ?array
    {
        $email = strtolower(trim($email));
        foreach ($this->rows as $row) {
            if (strtolower($row['email']) === $email) {
                return $row;
            }
        }
        return null;
    }

    /**
     * Cerca un alumne per DNI i correu (per al procés de login/registre).
     */
    public function getAlumneByDniAndEmail(string $dni, string $email): ?array
    {
        $dni   = strtoupper(trim($dni));
        $email = strtolower(trim($email));

        foreach ($this->rows as $row) {
            if (
                strtoupper($row['dni'])   === $dni &&
                strtolower($row['email']) === $email
            ) {
                return $row;
            }
        }
        return null;
    }

    /**
     * Comprova si un DNI existeix al CSV.
     */
    public function dniExists(string $dni): bool
    {
        return $this->getAlumneByDni($dni) !== null;
    }

    /**
     * Comprova si un correu existeix al CSV.
     */
    public function emailExists(string $email): bool
    {
        return $this->getAlumneByEmail($email) !== null;
    }

    // ---------------------------------------------------------------
    // Consultes sobre estudis
    // ---------------------------------------------------------------

    /**
     * Retorna tots els estudis únics (tipus + nivell) del CSV.
     */
    public function getAllEstudis(): array
    {
        $estudis = [];
        $seen    = [];

        foreach ($this->rows as $row) {
            $key = $row['estudi_tipus'] . '_' . $row['estudi_nivell'];
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $estudis[]  = [
                    'tipus'  => $row['estudi_tipus'],
                    'nivell' => $row['estudi_nivell'],
                ];
            }
        }

        return $estudis;
    }

    /**
     * Retorna els estudis únics agrupats per tipus.
     * Exemple: ['ESO' => ['1','2','3','4'], 'BAT' => ['1','2'], ...]
     */
    public function getEstudisGrouped(): array
    {
        $grouped = [];
        foreach ($this->getAllEstudis() as $estudi) {
            $grouped[$estudi['tipus']][] = $estudi['nivell'];
        }
        return $grouped;
    }

    /**
     * Retorna les assignatures per a un estudi concret (tipus + nivell).
     */
    public function getAssignaturesByEstudi(string $tipus, string $nivell): array
    {
        foreach ($this->rows as $row) {
            if (
                strtoupper($row['estudi_tipus']) === strtoupper($tipus) &&
                $row['estudi_nivell'] === $nivell
            ) {
                return $row['assignatures'];
            }
        }
        return [];
    }

    /**
     * Retorna les assignatures per a l'estudi d'un alumne concret (per DNI).
     */
    public function getAssignaturesForAlumne(string $dni): array
    {
        $alumne = $this->getAlumneByDni($dni);
        if (!$alumne) {
            return [];
        }
        return $alumne['assignatures'];
    }
}
