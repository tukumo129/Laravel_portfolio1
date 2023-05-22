<?php

namespace App\Calendar;

use Illuminate\Database\Eloquent\Model;

class ExtraHolidays extends Model
{
    const OPEN = 1;
    const CLOSE = 2;
    protected $table = "extra_holidays";

    protected $fillable = [
        "holiday_date",
        "holiday_type",
        "comment"
    ];
    function isClose($date) {
        return $this->getExtraHolidayType($date) == ExtraHolidays::CLOSE;
    }
    function isOpen($date) {
        return $this->getExtraHolidayType($date) == ExtraHolidays::OPEN;
    }

	function isUpdate($holiday_type){
		return $holiday_type == ExtraHolidays::OPEN || $holiday_type == ExtraHolidays::CLOSE;
	}

    public static function getExtraHolidayWithMonth($ym){
		return ExtraHolidays::where("holiday_date", 'like', $ym . '%')
            ->get()->keyBy("holiday_date");
	}

    public function getExtraHolidayType($date){
		$extraHolidays = ExtraHolidays::where("holiday_date", '=', $date)
		->get()->keyBy("holiday_date");

        if(isset($extraHolidays[$date])){
            return $extraHolidays[$date]->holiday_type;
        }
        return 0;
	}

    public static function updateExtraHolidayWithMonth($ym, $input){
		$extraHolidays = self::getExtraHolidayWithMonth($ym);
		foreach($input as $holiday_date => $array){

			if(isset($extraHolidays[$holiday_date])){	//既に作成済の場合

				$extraHoliday = $extraHolidays[$holiday_date];
				$extraHoliday->fill($array);

				//CloseかOpen指定の場合は上書き
				if($extraHoliday->isUpdate($extraHoliday->holiday_type)){
					$extraHoliday->save();

				//指定なしを選択している場合は削除
				}else{
					$extraHoliday->delete();
				}
				continue;
			}

			$extraHoliday = new ExtraHolidays();
			$extraHoliday->holiday_date = $holiday_date;
			$extraHoliday->fill($array);
			//CloseかOpen指定の場合は保存
			if($extraHoliday->isUpdate($extraHoliday->holiday_type)){
				$extraHoliday->save();
			}
		}
	}
}
