<?php
namespace App\Calendar\planSetting;

use Carbon\Carbon;

use App\Calendar\CalendarWeekDay;
use App\Calendar\HolidaySetting;
use App\Calendar\WorkPlan;

class CalendarWeekDayPlanSetting extends CalendarWeekDay {

	public $workPlan = null; 
	public $extraHoliday = null; 

	/**
	 * @return 
	 */
	function render(){
		//selectの名前
		$select_form_name = "work_plan[" . $this->carbon->format("Ymd") . "][date_flag]";
		//コメントのinputの名前
		$comment_form_name = "work_plan[" . $this->carbon->format("Ymd") . "][comment]";
		
		//コメントの値
		$comment = ($this->workPlan) ? $this->workPlan->comment : '';
		
		//HTMLの組み立て
		$html = [];
		
		//日付
		$html[] = '<p class="day">' . $this->carbon->format("j"). '</p>';
		//臨時営業・臨時休業設定
		$html[] = '<select name="'. $select_form_name . '" class="form-control">';

		$workPlans = [];
		if($this->isHoliday) {
			$workPlans = WorkPlan::getHolidayWorkPlans();
		} else {
			$workPlans = WorkPlan::getWorkPlans();
		}

		$dateFlag = ($this->workPlan) ? $this->workPlan->date_flag : '';

		foreach($workPlans as $data_key => $value) {
			$selected = '';
			if($value == $dateFlag) {
				$selected = 'selected';
			}
			$html[] = '<option value="'.$value.'" '.$selected.'>'.$data_key.'</option>';
		}
		$html[] = '</select>';
		//コメント
		$html[] = '<input class="form-control" type="text" name="'.$comment_form_name.'" value="'.e($comment).'" />';
		
		return implode("", $html);
	}
	
	function getClassName(){
		$classNames = [ "day-" . strtolower($this->carbon->format("D")) ];
		if($this->extraHoliday){
			if($this->extraHoliday->isClose()){
				$classNames[] = "day-close"; //臨時営業
			}
		}else if($this->isHoliday){
			
			$classNames[] = "day-close";
		}
		return implode(" ", $classNames);
	}
}