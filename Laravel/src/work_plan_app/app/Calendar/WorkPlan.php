<?php

namespace App\Calendar;

use Illuminate\Database\Eloquent\Model;

class WorkPlan extends Model
{

	protected $table = "work_plan";

    protected $fillable = [
		"user_id",
        "date_flag",
        "comment"
    ];
	protected const HOLIDAYWORKPLANS = [
		'休日' => 0,
		'休日出勤' => 1,
	];
	protected const WORKPLANS = [
		'通常勤務' => 0,
		'在宅' => 2,
		'休暇(全日休)' => 3,
		'休暇(午前休)' => 4,
		'休暇(午後休)' => 5,
		'振替休日' => 6		
	];


	public static function getHolidayWorkPlans () {
		return WorkPlan::HOLIDAYWORKPLANS;
	}
	public static function getWorkPlans () {
		return WorkPlan::WORKPLANS;
	}

    public static function getWorkPlanWithMonth($ym){
		$user = \Auth::user();

		return WorkPlan::where([
			['date_key', 'like', $ym . '%'],
			['user_id', '=' ,$user['id']]
			])->get()->keyBy("date_key");
	}
    
    public static function updateWorkPlanWithMonth($ym, $input){
		$user = \Auth::user();
		$workPlans = self::getWorkPlanWithMonth($ym);
		foreach($input as $date_key => $array){
			
			if(isset($workPlans[$date_key])){	//既に作成済の場合

				$workPlan = $workPlans[$date_key];
				$workPlan->fill($array);

				if(empty($workPlan->date_flag) && empty($workPlan->comment)){
					$workPlan->delete();
				}else{
					$workPlan->save();
				}
				continue;
			}

			$workPlan = new WorkPlan();
			$workPlan->user_id = $user['id'];
			$workPlan->date_key = $date_key;
			$workPlan->fill($array);
			//CloseかOpen指定の場合は保存
			if(!(empty($workPlan->date_flag) && empty($workPlan->comment))){
				$workPlan->save();
			}
		}
	}
}
