<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\SysOrg;
use app\models\SysOrgSearch;
use app\models\SysOrgRel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\db\Query;


class SysOrgController extends Controller{

	public $parent_org;
	public $child_org;
	public $ref_org_type;

	public function actionIndex(){

		$searchModel = new SysOrgSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [	
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($id)
    {

    	$searchModel = new SysOrgSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'sys_org' => $this->findModel($id, 'sys_org'),	
            'sys_org_rel' => $this->findModel($id, 'sys_org_rel'),	
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

	public function actionCreate(){

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
		else if($sys_org->load(Yii::$app->request->post())){
			$isValid = $sys_org->validate();
			if($isValid){
				$sys_org->save();
				return $this->redirect(['view', 'id' => $sys_org->id]);
			}
		}

		return $this->render('create', [
			'sys_org' => $sys_org,
			'sys_org_rel' => $sys_org_rel,
		]);
	}

	public function actionUpdate($id){

		$sys_org = $this->findModel($id, 'sys_org');
		$searchModel = new SysOrgSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        if($sys_org->load(Yii::$app->request->post()) && $sys_org_rel->load(Yii::$app->request->post())){
			$isValid = $sys_org->validate();
			$isValid = $sys_org_rel->validate() && $isValid; 
			if($isValid){
				$sys_org->save(false);
				$sys_org_rel->save(false);
				return $this->redirect(['view','id' => $sys_org->id]);
			}
		}
		else if($sys_org->load(Yii::$app->request->post())){
			$isValid = $sys_org->validate();
			if($isValid){
				$sys_org->save();
				return $this->redirect(['view', 'id' => $sys_org->id]);
			}
		}

        return $this->render('update', [
        	'sys_org' => $sys_org,
        	'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionDeleteRel($id){

		$model = SysOrgRel::find()
				->where(['child_id' => $id])
				->one();

		$model->end_date = date("Y-m-d");
		$model->updateAttributes(['end_date']);

		$model = SysOrgRel::find();

		$this->findRel($id, $model);

		Yii::$app->session->setFlash('success', 'Дерево наследований удалено');
	
		return $this->redirect(['index']);

	}

	protected function findRel($id, $model){

		if(($records = $model->where(['parent_id' => $id])
                    ->andWhere('end_date > :date', [':date' => date("Y-m-d")])
                	->all()) != null){
			$id = [];

			foreach($records as $record){

                $record->end_date = date("Y-m-d");
                $record->updateAttributes(['end_date']);
             	array_push($id, $record->child_id);
            }

            $this->findRel($id, $model);
		}
	}

	protected function findModel($id, $title){

		if($title == 'sys_org'){

			if(($model = SysOrg::find()
						->where(['sys_org.id' => $id])
						->joinWith('ref_org_type')
						->one()) !== null){
			return $model;
			}
		}
		else if($title == 'sys_org_rel'){

			if(($model = SysOrgRel::find()
						->where(['child_id' => $id])
						->joinWith('parent_org')
						->one()) !== null){
			return $model;
			}
		}

		return [];
	}

	public function actionOrganizate($relation, $value, $id){

		$model = new SysOrgRel();

		$orgs = $model->find()
			->joinWith($relation)
			->where([$value => $id])
			->all();

		if($relation == 'parent_org'){

			foreach($orgs as $org){
					echo "<option value='".$org->child_id."'>".$org->child_org->name."</option>";
			}
			echo "<option value='0'>Все комитеты</option>";
		}
		else if($relation == 'child_org'){

			foreach($orgs as $org){
					echo "<option value='".$org->parent_id."'>".$org->parent_org->name."</option>";
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