<?php
namespace App\Calendar\Form;
use Carbon\Carbon;
use App\Calendar\CalendarView;
/**
* 表示用
*/
class CalendarFormView extends CalendarView {
    function getCalendar($setting,$holidays){
		return new GetCalendarForm($setting,$holidays);
	}
    function dayRendar($day){
		$html = [];
		$html[] = '<td class="'.$day->getClassName().'">';
		$html[] =  $day->render();
		$html[] = '</td>';
		return implode("", $html);
	}
	protected function getWeek(Carbon $date, $index = 0){
			$week = new CalendarWeekForm($date, $index);

		//臨時営業日を設定する
		$start = $date->copy()->startOfWeek()->format("Ymd");
		$end = $date->copy()->endOfWeek()->format("Ymd");

		$week->holidays = $this->holidays->filter(function($value, $key) use($start, $end){
			return $key >= $start && $key <= $end;
		})->keyBy("date_key");

		return $week;
	}
}