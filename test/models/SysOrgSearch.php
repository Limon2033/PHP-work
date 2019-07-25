<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SysOrg;

class SysOrgSearch extends SysOrg{

	public $child_rel;
	public $ref_org_type;

	public function attributes(){
		return array_merge(parent::attributes(), ['ref_org_type.type']);
	}

	public function rules(){
		return [
			[['name', 'ref_org_type.type', 'bin'], 'safe'],
		];
	}

	public function scenarios(){
		return Model::scenarios();
	}

	public function search($params, $id = 0){

		$query = SysOrg::find();

		if($id != 0){
			$query->joinWith(['child_rel', 'ref_org_type'])->where(['parent_id' => $id])
			->andWhere('end_date > :date', [':date' => date("Y-m-d")]);
		}
		else{
			$query->joinWith(['ref_org_type']);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		$dataProvider->sort->attributes['ref_org_type.type'] = [
    		'asc' => ['ref_org_type.type' => SORT_ASC],
    		'desc' => ['ref_org_type.type' => SORT_DESC],
		];
		
		$this->load($params);
		
		if(!$this->validate()){
			return $dataProvider;
		}
		
		$query->andfilterWhere(['like', 'name', $this->name,]);
		$query->andFilterWhere(['like', 'ref_org_type.type', $this->getAttribute('ref_org_type.type'),]);
		$query->andFilterWhere(['like', 'bin', $this->bin,]);
		return $dataProvider;
	}
}

?>