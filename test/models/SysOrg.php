<?php

namespace app\models;

use yii\db\ActiveRecord;

class SysOrg extends ActiveRecord{

	public static function tableName(){
		return 'sys_org';
	}

	public function rules(){
		return [
			['name', 'required', 'message' => 'Заполните имя орагнизации'],
			['type', 'safe'],
			['bin', 'string', 'length' => [12, 12], 'tooShort' => 'БИН должен содержать 12 символов', 'tooLong' => 'БИН должен содержать 12 символов'],
			['bin', 'required', 'message' => 'Заполните БИН'],
			['bin', 'unique', 'targetClass' => SysOrg::className(),'message' => 'Такой БИН уже существует'],
		];
	}

	public function getRef_org_type(){
		return $this->hasOne(RefOrgType::className(), ['id' => 'type']);
	}

	public function getChild_rel(){
		return $this->hasMany(SysOrgRel::classname(), ['child_id' => 'id']);
	}

	public function getParent_rel(){
		return $this->hasMany(SysOrgRel::classname(), ['parent_id' => 'id']);
	}

	public function attributeLabels(){

		return [
			'name' => 'Имя организации',
			'type' => 'Тип орагнизации',
			'bin' => 'БИН',
		];
	}

}

?>