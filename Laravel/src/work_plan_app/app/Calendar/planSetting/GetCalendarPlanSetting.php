<?php
namespace App\Calendar\planSetting;

use Carbon\Carbon;
use App\Calendar\GetCalendar;
use App\Calendar\HolidaySetting;
use App\Calendar\WorkPlan;

class GetCalendarPlanSetting extends GetCalendar {
	/**
	 * @return CalendarWeekDayForm
	 */

	public $holidays = [];
	public $workPlans = [];

	function getDay(Carbon $date){
		$day = new CalendarWeekDayPlanSetting($date);
		$day->checkHoliday($this->setting, $this->holidays);

		if(isset($this->holidays[$day->getDateKey()])){
			$day->extraHoliday = $this->holidays[$day->getDateKey()];
		}
		
		$this->workPlans = WorkPlan::getWorkPlanWithMonth($day->getMonthKey());
		if(isset($this->workPlans[$day->getDateKey()])){
			$day->workPlan = $this->workPlans[$day->getDateKey()];
		}
		return $day;
	}
}