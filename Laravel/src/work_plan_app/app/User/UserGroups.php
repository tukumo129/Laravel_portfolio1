<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    protected $table = "user_groups";

    protected $fillable = [
		"group_name",
    ];

    protected $userTypes = [
        '通常' => '1',
        '管理者' => '2',
    ];

    public function getUserTypes() {
        return $this->userTypes;
    }

	public static function getUserGroups () {
		return UserGroups::get()->keyBy("group_name");
    }

    public static function updateUserGroup($input){
		$userGroups = self::getUserGroups();
		foreach($input as $group_id => $group_name){
            if(isset($userGroups[$group_name])) {
                $userGroup = new UserGroups();
                // $userGroup->user_id = $user['id'];
                $userGroup->group_name = $group_name;
                $userGroup->fill($array);
                $AttendanceSchedule->save();
            };
		}
	}
}
