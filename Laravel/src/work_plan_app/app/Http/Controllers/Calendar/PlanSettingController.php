<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendar\planSetting\CalendarPlanSettingView;
use App\Calendar\WorkPlan;

class PlanSettingController extends Controller
{
    public function form(){
		$calendar = new CalendarPlanSettingView(time());
		return view('calendar/plan_setting_form', [
			"calendar" => $calendar
		]);
	}
	public function update(Request $request){
		$user = \Auth::user();
		$input = $request->get("work_plan");
		WorkPlan::updateWorkPlanWithMonth(date("Ym"), $input);
		return redirect()
			->action("Calendar\PlanSettingController@form")
			->withStatus("保存しました");
	}
}
