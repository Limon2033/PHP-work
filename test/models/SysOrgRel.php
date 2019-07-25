<?php

namespace app\models;

use yii\db\ActiveRecord;

class SysOrgRel extends ActiveRecord{

	public static function tableName(){
		return 'sys_org_rel';
	}

	public function rules(){

		return [
			['parent_id', 'required', 'message' => 'Заолните поле курирующей организации'],
			['child_id', 'default', 'value' => 1],
			[['start_date', 'end_date'], 'date'],
		];
	}

	public function attributeLabels(){

		return [
			'start_date' => 'Дата начала управления',
			'end_date' => 'Дата завершения упрпавления',
		];
	}
	
	public function getChild_org(){
		return $this->hasOne(SysOrg::classname(), ['id' => 'child_id']);
	}

	public function getParent_org(){
		return $this->hasOne(SysOrg::classname(), ['id' => 'parent_id']);
	}

	public function afterSave($insert, $changedAttributes){

		if($insert){
			$this->start_date = date("Y-m-d");
			$this->end_date = date("Y-m-d", strtotime("2099-12-31"));
			$max = SysOrg::find()->max('id');
			$child = SysOrg::find()
							->select(['id'])
							->where(['id' => $max])
							->one()->id;
			$this->child_id = $child;

			$this->updateAttributes(['start_date', 'end_date', 'child_id']);	
		}
		parent::afterSave($insert, $changedAttributes);
	}
}

?>