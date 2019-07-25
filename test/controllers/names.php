<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\SysOrg;
use app\models\SysOrgSearch;
use app\models\SysOrgRel;
use yii\helpers\ArrayHelper;


class NamesController extends Controller{

	public function actionIndex(){

		$searchModel = new SysOrgSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [	
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionCreate($key = false){

		$sys_org = new SysOrg();
		$sys_org_rel = new SysOrgRel();

		if($sys_org->load(Yii::$app->request->post()) && $sys_org_rel->load(Yii::$app->request->post())){
			$isValid = $sys_org->validate();
			$isValid = $sys_org_rel->validate() && $isValid; 
			if($isValid){
				$sys_org->save(false);
				$sys_org_rel->save(false);
				return $this->redirect(['view', 'id' => $sys_org->id]);
			}
		}


		return $this->render('create', [
			'sys_org' => $sys_org,
			'sys_org_rel' => $sys_org_rel,
		]);	
	}

	public function actionUpdate($id){

	}

	public $parent_org;
	public $child_org;

	public function actionOrganizate($relation, $value, $id){

		$model = new SysOrgRel();

		$orgs = $model->find()
			->joinWith($relation)
			->where([$value => $id])
			->all();

		if($relation == 'parent_org'){

			foreach($orgs as $org){
					echo "<option value='".$org->child."'>".$org->child_org->name."</option>";
			}
			echo "<option value='0'>Все комитеты</option>";
		}
		else if($relation == 'child_org'){

			foreach($orgs as $org){
					echo "<option value='".$org->parent."'>".$org->parent_org->name."</option>";
			}
			echo "<option value='0'>Все министерства</option>";
		}
	}

	public function actionReform($type){
		$model = new SysOrg();

		$orgs = $model->find()
			->select(['id', 'name'])
			->where(['type' => $type])
			->all();

		if($type == 1){
			$string = 'министерство...';
		}
		else if($type == 2){
			$string = 'комитет...';
		}

		echo "<option value=''>".$string."</option>";

		foreach($orgs as $org){
					echo "<option value='".$org->id."'>".$org->name."</option>";
			}
	}
}
?>