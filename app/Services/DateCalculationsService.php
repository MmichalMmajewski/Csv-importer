<?php

namespace App\Services;
use Carbon\Carbon;

class DateCalculationsService 
{
    public function getSecondsFromDate(Carbon $startDate)
    {
       return (now()->diffInRealMilliseconds(Carbon::parse($startDate))/1000);
    }
}
