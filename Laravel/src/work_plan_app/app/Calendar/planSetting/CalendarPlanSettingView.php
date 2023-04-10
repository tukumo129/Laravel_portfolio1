<?php
namespace App\Calendar\planSetting;
use Carbon\Carbon;
use App\Calendar\CalendarView;
/**
* 表示用
*/
class CalendarPlanSettingView extends CalendarView {
    function getCalendar($setting,$holidays){
		return new GetCalendarPlanSetting($setting,$holidays);
	}
    function dayRendar($day){
		$html = [];
		$html[] = '<td class="'.$day->getClassName().'">';
		$html[] =  $day->render();
		$html[] = '</td>';
		return implode("", $html);
	}
	// protected function getWeek(Carbon $date, $index = 0){
	// 		$week = new CalendarWeekPlanSetting($date, $index);

	// 	//臨時営業日を設定する
	// 	$start = $date->copy()->startOfWeek()->format("Ymd");
	// 	$end = $date->copy()->endOfWeek()->format("Ymd");

	// 	$week->holidays = $this->holidays->filter(function($value, $key) use($start, $end){
	// 		return $key >= $start && $key <= $end;
	// 	})->keyBy("date_key");

	// 	return $week;
	// }
}