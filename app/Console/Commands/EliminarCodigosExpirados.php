<?php
// app/Console/Commands/EliminarCodigosExpirados.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Examen;
use Carbon\Carbon;

class EliminarCodigosExpirados extends Command
{
    /**
     * El nombre y la firma del comando.
     *
     * @var string
     */
    protected $signature = 'codigos:eliminar-expirados';

    /**
     * La descripción del comando.
     *
     * @var string
     */
    protected $description = 'Elimina los códigos expirados de la base de datos';

    /**
     * Ejecutar el comando.
     *
     * @return void
     */
    public function handle()
    {
        // Obtener los códigos expirados
        $now = Carbon::now();
        $codigosExpirados = Examen::whereNotNull('codigo_expiracion')
                                  ->where('codigo_expiracion', '<', $now)
                                  ->get();

        if ($codigosExpirados->isEmpty()) {
            $this->info('No hay códigos expirados.');
        } else {
            // Eliminar los códigos expirados
            Examen::whereNotNull('codigo_expiracion')
                  ->where('codigo_expiracion', '<', $now)
                  ->delete();

            $this->info('Códigos expirados eliminados correctamente.');
        }
    }
}
