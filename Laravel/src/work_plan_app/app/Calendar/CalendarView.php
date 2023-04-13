<?php

namespace App\Calendar;

use Carbon\Carbon;
use App\Calendar\ExtraHoliday;

class CalendarView
{
    protected $carbon;
    protected $holidays = [];

    function __construct($date) {
        $this->carbon = new Carbon($date);
    }

    public function getTitle() {
        return $this->carbon->format('Y年n月');
    }

    function render() {
		$setting = HolidaySetting::first();
		if(!$setting)$setting = new HolidaySetting();

		$setting->loadHoliday($this->carbon->format("Y"));
		$this->holidays = ExtraHoliday::getExtraHolidayWithMonth($this->carbon->format("Ym"));
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<thead>';
		$html[] = '<tr>';
		$html[] = '<th>月</th>';
		$html[] = '<th>火</th>';
		$html[] = '<th>水</th>';
		$html[] = '<th>木</th>';
		$html[] = '<th>金</th>';
		$html[] = '<th>土</th>';
        $html[] = '<th>日</th>';
		$html[] = '</tr>';
		$html[] = '</thead>';

 		$html[] = '<tbody>';
		
		$tmp = $this->getCalendar($setting,$this->holidays);
		$month = $tmp->getMonth($this->carbon->copy());
		$count = 0;
		foreach($month as $week){
			$html[] = '<tr class=week-"'.$count.'">';
			foreach($week as $day){
				$html[] = $this->dayRendar($day);
			}
			$html[] = '</tr>';
			$count++;
		}		
		$html[] = '</tbody>';
		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
    }
	function getCalendar($setting,$holidays) {
		return new GetCalendar($setting,$this->holidays);
	}
	
	function dayRendar($day) {
		$html = [];
		$html[] = '<td class="'.$day->getClassName().'">';
		$html[] =  '<p class="day">' . $day->getCarbon()->format("j"). '</p>';
		$html[] = '</td>';
		return implode("", $html);
	}
}
