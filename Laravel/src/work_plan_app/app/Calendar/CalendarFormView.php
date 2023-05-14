<?php
namespace App\Calendar;
use Carbon\Carbon;
use App\Calendar\CalendarView;
use App\Calendar\AttendanceSchedules;
use App\Calendar\Holidays;
use App\Calendar\ExtraHolidays;
/**
* 表示用
*/
class CalendarFormView extends CalendarView {

	function dayRendar($day) {
		$html = [];
		$html[] = '<td class="'.$this->getDayClass($day).'">';
		$html[] =  $this->dayFormRender($day);
		$html[] = '</td>';
		return implode("", $html);
	}

	function dayFormRender($day){
		$select_form_name = "extra_holiday[" . $day->format("Ymd") . "][holiday_type]";
		
		$defaultValue = ($this->holidays->isHoliday($day)) ? "休み" : "営業日";
		$isSelectedExtraClose = ($this->extraHolidays->isClose($day->format("Ymd"))) ? 'selected' : '';
		$isSelectedExtraOpen = ($this->extraHolidays->isOpen($day->format("Ymd"))) ? 'selected' : '';
		
		$html = [];
		
		$html[] = '<p class="day">' . $day->format("j"). '</p>';
		$html[] = '<select name="'. $select_form_name . '" class="form-control">';
		$html[] = '<option value="0">' . $defaultValue . '</option>';
		if($this->holidays->isHoliday($day)) {
			$html[] = '<option value="'.ExtraHolidays::OPEN.'" ' . $isSelectedExtraOpen . '>営業日</option>';
		} else {
			$html[] = '<option value="'.ExtraHolidays::CLOSE.'" ' . $isSelectedExtraClose . '>休み</option>';
		}
		$html[] = '</select>';		
		return implode("", $html);

	}
}