<?php

namespace App\Console\Commands;
use App\Services\TicketService;

use Illuminate\Console\Command;

class GenerarRecordatorio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorio:generar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar notificaciones de recordatorio para los tickets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ticketService = new TicketService();
        $ticketService->generarRecordatorio();
        $this->info('Notificaciones de recordatorio generadas.');
    }
}
