<?php

use Illuminate\Support\Facades\Schedule;

// Esegue il controllo scadenze ogni mattina alle 08:00
Schedule::command('app:send-expiry-notifications')->dailyAt('08:00');