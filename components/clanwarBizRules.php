<?php
class clanwarBizRules {
	

	public static function istSquadLeader($squad_id=0) {
		
		$attributes['user_id'] 	= Yii::app()->user->getId();
		$attributes['squad_id'] = $squad_id;
		
		$sql = "SELECT * FROM user2squad WHERE user_id = ".Yii::app()->user->getId()." AND squad_id = ".$squad_id." AND (leader_flag = 1 OR orga_flag = 1)";  
				
		$res = Yii::app()->db->createCommand($sql)->queryRow();

		if(!empty($res)) {
			return true;
		} else {
			return false;
		}
	}

	public static function istSquadMember($squad_id=0) {
	
		$attributes['user_id'] 	= Yii::app()->user->getId();
		$attributes['squad_id'] = $squad_id;
	
		$sql = "SELECT * FROM user2squad WHERE user_id = ".Yii::app()->user->getId()." AND squad_id = ".$squad_id."";
	
		$res = Yii::app()->db->createCommand($sql)->queryRow();
	
		if(!empty($res)) {
			return true;
		} else {
			return false;
		}
	}	
	
	
	public static function istMeinEintrag($user_id) {
		if($user_id != Yii::app()->user->getId()) {
			return false;
		}
		return true;
	}	
	
}
?>