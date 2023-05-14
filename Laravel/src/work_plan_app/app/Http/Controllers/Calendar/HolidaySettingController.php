<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendar\Holidays;

class HolidaySettingController extends Controller
{
	function form(){
		
		//取得
        $holidays = Holidays::first();
        if(!$holidays)$holidays = new Holidays();
		return view("calendar/holiday_setting_form", [
			"holidays" => $holidays,
		]);
	}

	function update(Request $request){
		//取得
		$holidays = Holidays::get()->keyBy("holiday_day_of_week");	
		$input = $request->all();
		foreach($input as $holidayDayOfWeek => $holidayType){
			if(isset($holidays[$holidayDayOfWeek])){
				$holiday = $holidays[$holidayDayOfWeek];
				$holiday->holiday_type = $holidayType;
			} else {
				$holiday = new Holidays();
				$holiday->holiday_day_of_week = $holidayDayOfWeek;
				$holiday->holiday_type = $holidayType;
			}
			$holiday->save();
		}
	
		return redirect()
			->action("Calendar\HolidaySettingController@form")
			->withStatus("保存しました");
	}
}