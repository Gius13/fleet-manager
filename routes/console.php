<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('check:deadlines')->dailyAt('08:00');
// Esegue il controllo scadenze ogni mattina alle 08:00
Schedule::command('app:send-expiry-notifications')->dailyAt('08:00');