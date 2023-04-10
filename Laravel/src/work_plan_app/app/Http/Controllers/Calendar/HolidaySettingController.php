<?php
namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendar\HolidaySetting;

class HolidaySettingController extends Controller
{
	
	function form(){
		
		//取得
        $setting = HolidaySetting::first();
        if(!$setting)$setting = new HolidaySetting();
		// $setting = HolidaySetting::firstOrCreate();
		return view("calendar/holiday_setting_form", [
			"setting" => $setting,
			"FLAG_OPEN" => HolidaySetting::OPEN,
			"FLAG_CLOSE" => HolidaySetting::CLOSE
		]);
	}
	function update(Request $request){
		//取得
        $setting = HolidaySetting::first();
        if(!$setting)$setting = new HolidaySetting();
		// $setting = HolidaySetting::firstOrCreate();
		//更新
		$setting->update($request->all());
		$setting->save(); // 追記
		return redirect()
			->action("Calendar\HolidaySettingController@form")
			->withStatus("保存しました");
	}
}