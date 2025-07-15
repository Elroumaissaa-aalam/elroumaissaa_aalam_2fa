<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    User::all()->each(function ($user) {
        $user->two_factor_code = random_int(100000, 999999);
        $user->two_factor_expires_at = now()->addMinute();
        $user->save();
    });
})->everyMinute()->evenInMaintenanceMode();
