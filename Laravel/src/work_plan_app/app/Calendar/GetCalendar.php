<?php

namespace App\Calendar;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GetCalendar extends Model
{
    protected $setting;
    protected $holidays;
    
    function __construct($setting,$holidays){
        $this->setting = $setting;
        $this->holidays = $holidays;
    }

    function getMonth(Carbon $date) {
        $Month = [];
        $tmpDay = $date->copy()->firstOfMonth();
        $lastDay = $date->copy()->lastOfMonth();

        while($tmpDay->lte($lastDay)){
            $Month[] = $this->getWeek($tmpDay);
            $tmpDay->addDay(7);
        }
        return $Month;
    }

    function getWeek(Carbon $date){

        $weekDays = [];

        //開始日〜終了日
        $startDay = $date->copy()->startOfWeek();
        $lastDay = $date->copy()->endOfWeek();

        //作業用
        $tmpDay = $startDay->copy();

        //月曜日〜日曜日までループ
        while($tmpDay->lte($lastDay)){

            //前の月、もしくは後ろの月の場合は空白を表示
            if($tmpDay->month != $date->month){
                $day = new CalendarDayBlank($tmpDay->copy());
                $weekDays[] = $day;
                $tmpDay->addDay(1);
                continue;	
            }
                
            //今月
            $weekDays[] = $this->getDay($tmpDay->copy());
            //翌日に移動
            $tmpDay->addDay(1);
        }
        return $weekDays;
    }
    function getDay(Carbon $date){
		$day = new CalendarWeekDay($date);
		$day->checkHoliday($this->setting, $this->holidays);
        return $day;
	}
}
