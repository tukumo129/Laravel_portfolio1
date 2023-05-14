<?php

namespace App\Calendar;

use Illuminate\Database\Eloquent\Model;

class AttendanceSchedules extends Model
{

	protected $table = "attendance_schedules";

    protected $fillable = [
		"user_id",
		"scheduled_date",
		"type",
		"note",
		"status",
    ];

	protected const HOLIDAYATTENDANCESCHEDULES = [
		'休日' => 0,
		'休日出勤' => 1,
	];

	protected const ATTENDANCESCHEDULES = [
		'通常勤務' => 0,
		'在宅' => 2,
		'休暇(全日休)' => 3,
		'休暇(午前休)' => 4,
		'休暇(午後休)' => 5,
		'振替休日' => 6		
	];


	public static function getHolidayAttendanceSchedules () {
		return AttendanceSchedules::HOLIDAYATTENDANCESCHEDULES;
	}
	public static function getAttendanceSchedules () {
		return AttendanceSchedules::ATTENDANCESCHEDULES;
	}

    public static function getAttendanceScheduleWithMonth($ym){
		$user = \Auth::user();
		return AttendanceSchedules::where([
			['scheduled_date', 'like', $ym . '%'],
			['user_id', '=' ,$user['id']]
			])->get()->keyBy("scheduled_date");
	}
    
    public static function updateAttendanceScheduleWithMonth($ym, $input){
		$user = \Auth::user();
		$AttendanceSchedules = self::getAttendanceScheduleWithMonth($ym);
		foreach($input as $scheduled_date => $array){
			if(isset($AttendanceSchedules[$scheduled_date])){	//既に作成済の場合
				$AttendanceSchedule = $AttendanceSchedules[$scheduled_date];
				$AttendanceSchedule->fill($array);
				if(empty($AttendanceSchedule->type) && empty($AttendanceSchedule->note)){
					$AttendanceSchedule->delete();
				}else{
					$AttendanceSchedule->save();
				}
				continue;
			}
			$AttendanceSchedule = new AttendanceSchedules();
			$AttendanceSchedule->user_id = $user['id'];
			$AttendanceSchedule->scheduled_date = $scheduled_date;
			$AttendanceSchedule->fill($array);
			//CloseかOpen指定の場合は保存
			if(!(empty($AttendanceSchedule->type) && empty($AttendanceSchedule->note))){
				$AttendanceSchedule->save();
			};
		}
	}
}
