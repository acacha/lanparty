<?php

namespace App\Http\Controllers\Traits;

use Carbon\Carbon;

/**
 * Trait RegistrationsAreEnabled.
 *
 * @package App\Http\Controllers\Traits
 */
trait RegistrationsAreEnabled {
    /**
     * Check if registrations are enabled.
     *
     * @return bool
     */
    protected function registrationsAreEnabled()
    {
        return Carbon::parse(config('lanparty.registration_start_date'))->isPast();
    }
}