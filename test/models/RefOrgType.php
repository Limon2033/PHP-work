<?php

namespace app\models;

use yii\db\ActiveRecord;

class RefOrgType extends ActiveRecord{

	public function attributeLabels(){

		return [
			'type' => 'Тип организации'
		];
	}

	public static function tableName(){
		return 'ref_org_type';
	}
	
	public function getSys_org(){
		return $this->hasMany(SysOrg::className(), ['type' => 'id']);
	}
}

?>