<?php

namespace App\Listeners;

use App\Events\paiementStripe;
use App\Mail\InvitationMailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use App\Models\Transaction;
use Carbon\Carbon;

class StripeEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            $amountPaid = $event->payload['data']['object']['amount_total'];
            $amountPaidInDollars = $amountPaid / 100;
            $Date = Carbon::now('America/Toronto');
            Transaction::create([
                'montant' => $amountPaidInDollars,
                'dateHeure' => $Date,
                'idRdv' => env("ID_RDV"),
                'idTypeTransaction' => 1,
                'idMoyenPaiement' => 1
            ]);
        }
    }
}
