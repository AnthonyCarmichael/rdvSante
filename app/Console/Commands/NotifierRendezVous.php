<?php

namespace App\Console\Commands;

use App\Jobs\EnvoiRappelRendezVous;
use App\Models\Rdv;
use App\Notifications\RappelRendezVous;
use Illuminate\Console\Command;

class NotifierRendezVous extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notifier-rendez-vous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des rappels de rendez-vous 24h avant la date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        EnvoiRappelRendezVous::dispatch(); 
        $this->info('Rappels envoyés pour les rendez-vous prévus dans 24 heures.');
  
    }
}
