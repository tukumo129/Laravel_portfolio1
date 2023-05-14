<?php
namespace App\Calendar;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Yasumi\Yasumi;
class Holidays extends Model
{
    protected $table = 'holidays';
    const OPEN = 1;
    const CLOSE = 2;
    protected $holidayNames = [
        "月曜日" => "Mon",
        "火曜日" => "Tue",
        "水曜日" => "Wed",
        "木曜日" => "Thu",
        "金曜日" => "Fri",
        "土曜日" => "Sat",
        "日曜日" => "Sun",
        "祝日" => "Holiday"
    ];
    protected $fillable = [
		"holiday_day_of_week",
		"holiday_type"
    ];

    
	public function isHoliday($date): bool
    {
        $HolidayType = $this->getHolidayType($date->Format('D'));
        if ($HolidayType == self::CLOSE) {
            return true;
        }

        // 祝日かどうかを判定
        if(!$this->getHolidayType($this->holidayNames["祝日"])) {
            return false;
        }

        $yasumi = Yasumi::create('Japan', $date->year, 'ja_JP');
        $holidayDates = $yasumi->getHolidayDates();

        if (in_array($date->format('Y-m-d'), $holidayDates)) {
            return true;
        }

        return false;
    }

    public function getCheck($nameEn,$type) {
        if($this->getHolidayType($nameEn) == $type) {
            return 'checked';
        }
        return '';
    }

    public function getHolidayType($nameEn) {
		$holidays = Holidays::get()->keyBy("holiday_day_of_week");
        if(isset($holidays[$nameEn])){
            return $holidays[$nameEn]->holiday_type;
        }
        return 0;
    }

    public function render() {
        $html = [];
        $html[] = "<table class='table table-borderd'>";
        foreach($this->holidayNames as $name => $nameEn){
            $html[] = "<tr>";
            $html[] = "<th>" .$name. "</th>";
            $html[] = "<td>";
            $html[] = "<input type='radio' name='".$nameEn."' value='" .self::OPEN. "' " . $this->getCheck($nameEn,self::OPEN) . " id='".$nameEn."_open'/>";
            $html[] = "<label for='" .$nameEn. "_open'>営業日</label>";
            $html[] = "<input type='radio' name='".$nameEn."' value='" .self::CLOSE. "' " . $this->getCheck($nameEn,self::CLOSE). " id='".$nameEn."_close'/>";
            $html[] = "<label for='" .$nameEn. "_close'>休み</label>";
            $html[] = "</td>";
            $html[] = "</tr>";
        }
        $html[] = "</table>";

        return implode("", $html);
    }
}