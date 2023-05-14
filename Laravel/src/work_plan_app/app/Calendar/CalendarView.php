<?php

namespace App\Calendar;

use Carbon\Carbon;
use App\Calendar\Holidays;

class CalendarView
{
    protected $carbon;
	protected $attendanceScheduleWithMonth;
	protected $holidays;
	protected $extraHolidays;

	function __construct($date) {
        $this->carbon = new Carbon($date);
		$attendanceSchedule = new AttendanceSchedules();
		$this->attendanceScheduleWithMonth = $attendanceSchedule->getAttendanceScheduleWithMonth($this->carbon->format("Ym"));
		$this->holidays = new Holidays();
		$this->extraHolidays = new ExtraHolidays();
    }

    public function getTitle() {
        return $this->carbon->format('Y年n月');
    }
	
    function render() {
		// $setting = HolidaySetting::first();
		// if(!$setting)$setting = new HolidaySetting();

		// $setting->loadHoliday($this->carbon->format("Y"));
		// $this->holidays = ExtraHoliday::getExtraHolidayWithMonth($this->carbon->format("Ym"));
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
		
		$tmp = new Calendar();
		$month = $tmp->getMonthDates($this->carbon->copy());
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
	// function getCalendar($setting,$holidays) {
	// 	return new GetCalendar($setting,$this->holidays);
	// }
	
	function dayRendar($day) {
		$html = [];
		$html[] = '<td class="'.$this->getDayClass($day).'">';
		$html[] = '<p class="day">' . $day->format("j"). '</p>';
		$html[] = '</td>';
		return implode("", $html);
	}

	function getDayClass($day){
		$classNames = [];

		if($this->carbon->month == $day->month){
			$classNames = [ "day-" . strtolower($day->format("D")) ];
			if($this->extraHolidays->isClose($day->format("Ymd"))){
				$classNames[] = "day-close"; //臨時営業
			} else if($this->holidays->isHoliday($day)){
				$classNames[] = "day-close";
			}
		} else {
			$classNames[] = "day-blank";
		}
		return implode(" ", $classNames);
	}
}
