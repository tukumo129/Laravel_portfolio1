<?php
namespace App\Calendar;
use Carbon\Carbon;

class CalendarDayBlank extends CalendarWeekDay {

	function getClassName(){
		return "day-blank";
	}

	/**
	 * @return 
	 */
	function render(){
		return '';
	}
}