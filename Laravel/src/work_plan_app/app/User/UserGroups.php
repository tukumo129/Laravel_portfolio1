<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    protected $table = "user_groups";

    protected $fillable = [
		"group_name",
    ];

	public static function getUserGroups () {
		return UserGroups::get()->keyBy("group_name");
    }

    public static function updateUserGroup($input){
		$userGroups = self::getUserGroups();
		foreach($input as $group_id => $group_name){
            if(isset($userGroups[$group_name])) {
                $userGroup = new UserGroups();
                $userGroup->group_name = $group_name;
                $userGroup->fill($array);
                $AttendanceSchedule->save();
            };
		}
	}
}
