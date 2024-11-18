<?php

namespace App\Jobs;

use App\Models\Rdv;
use App\Notifications\RappelRendezVous;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class EnvoiRappelRendezVous implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $rendezvous = Rdv::where('dateHeureDebut','>', now()->addDay())
            ->where('dateHeureDebut','<', now()->addDay()->addMinute())->get();
        foreach ($rendezvous as $rdv) { 
            $rdv->client->notify(new RappelRendezVous($rdv));
        }
    }
}
