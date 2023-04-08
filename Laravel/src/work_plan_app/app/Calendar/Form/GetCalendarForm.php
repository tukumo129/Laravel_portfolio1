<?php
namespace App\Calendar\Form;

use Carbon\Carbon;
use App\Calendar\GetCalendar;
use App\Calendar\HolidaySetting;

class GetCalendarForm extends GetCalendar {
	/**
	 * @return CalendarWeekDayForm
	 */

	public $holidays = [];

	function getDay(Carbon $date){
		$day = new CalendarWeekDayForm($date);
		$day->checkHoliday($this->setting, $this->holidays);

		if(isset($this->holidays[$day->getDateKey()])){
			$day->extraHoliday = $this->holidays[$day->getDateKey()];
		}

		return $day;
	}
}