<?php

use App\Console\Commands\NotifierRendezVous;
use App\Jobs\EnvoiRappelRendezVous;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:notifier-rendez-vous')->everyMinute(); 