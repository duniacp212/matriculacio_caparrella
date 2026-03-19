<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder principal — executa tots els seeders en l'ordre correcte
 * per respectar les claus foranes.
 *
 * Execució:
 *   php spark db:seed DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to allow truncating tables with references
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');

        // 1. Taules sense dependències
        $this->call(FamiliaSeeder::class);
        $this->call(UsuariSeeder::class);

        // 2. Taules que depenen de familia
        $this->call(EstudiSeeder::class);

        // 3. Taules que depenen d'estudi
        // OptativaSeeder — sense dades de proves, es pot afegir si cal
        // $this->call(OptativaSeeder::class);

        // 4. Alumnes (sense dependències externes)
        $this->call(AlumneSeeder::class);

        // 5. Matrícula (depèn d'alumne, estudi i poble)
        // PobleSeeder — sense dades de proves, afegir si cal
        // $this->call(PobleSeeder::class);
        $this->call(MatriculaSeeder::class);

        // 6. Taules opcionals sense dades de proves
        // BonificacioSeeder, ServeisComplementarisSeeder — afegir quan calgui

        // Re-enable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');
    }
}