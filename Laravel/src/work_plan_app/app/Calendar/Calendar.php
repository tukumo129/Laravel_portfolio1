<?php

namespace App\Calendar;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{    
    //カレンダー用の配列を作成
    function getMonthDates(string $dateString): array{
        $carbon = new Carbon($dateString);
        $monthStart = $carbon->copy()->startOfMonth();
        $monthEnd = $carbon->copy()->endOfMonth();
        $monthDates = [];
    
        while ($monthStart->lte($monthEnd)) {
            $week = [];

            $weekStart = $monthStart->copy()->startOfWeek();
            $weekEnd = $monthStart->copy()->endOfWeek();

            while ($weekStart->lte($weekEnd)) {
                $week[] = $weekStart->copy();
                $weekStart->addDay(1);
            }
            $monthDates[] = $week;
            $monthStart->addWeek()->startOfWeek();
        }
        return $monthDates;
    }
}
