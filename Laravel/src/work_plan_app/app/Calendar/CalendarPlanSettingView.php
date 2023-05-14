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
class CalendarPlanSettingView extends CalendarView {

	function dayRendar($day) {
		$html = [];
		$html[] = '<td class="'.$this->getDayClass($day).'">';
		$html[] = $this->dayPlanRender($day);
		$html[] = '</td>';
		return implode("", $html);
	}

	function dayPlanRender($day){
		if(isset($this->attendanceScheduleWithMonth[$day->format("Ymd")])) {
			$dayAttendanceSchedule = $this->attendanceScheduleWithMonth[$day->format("Ymd")];
			$note = $dayAttendanceSchedule->note;
			$type = $dayAttendanceSchedule->type;
		} else {
			$dayAttendanceSchedule = '';
			$note = '';
			$type = '';
		}

		$isHoliday = $this->holidays->isHoliday($day) || $this->extraHolidays->isClose($day->format("Ymd"));

		$select_form_name = "attendance_schedules[" . $day->format("Ymd") . "][type]";
		$note_form_name = "attendance_schedules[" . $day->format("Ymd") . "][note]";		

		$html = [];
		$html[] = '<p class="day">' . $day->format("j"). '</p>';
		$html[] = '<select name="'. $select_form_name . '" class="form-control">';

		$attendanceSchedules = [];
		
		if($isHoliday) {
			$attendanceSchedules = AttendanceSchedules::getHolidayAttendanceSchedules();
		} else {
			$attendanceSchedules = AttendanceSchedules::getAttendanceSchedules();
		}


		foreach($attendanceSchedules as $scheduledType => $value) {
			$selected = '';
			if($value == $type) {
				$selected = 'selected';
			}
			$html[] = '<option value="'.$value.'" '.$selected.'>'.$scheduledType.'</option>';
		}

		$html[] = '</select>';
		$html[] = '<input class="form-control" type="text" name="'.$note_form_name.'" value="'.e($note).'" />';		
		return implode("", $html);
	}

}