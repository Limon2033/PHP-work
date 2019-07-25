<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\RefOrgType;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Организации';
$this->params['breadcrumbs'][] = $this->title;

$types = ArrayHelper::map(RefOrgType::find()->all(), 'type', 'type');

?>
<div class="sys-org-index">
	<h1><?= Html::encode($this->title)?></h1>

	<p>
        <?= Html::a('Добавить организацию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'emptyText' => 'Нет записей',
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			['attribute' => 'name', 'label' => 'Имя организации'],
			['attribute' => 'ref_org_type.type', 'label' => 'Тип организации', 'filter' => $types],
			['attribute' => 'bin', 'label' => 'БИН'],

			[
				'class' => 'yii\grid\ActionColumn', 
				'template' => '{view}{update}',
				'buttons' => [
					'view' => function($url, $model, $key){
						return Html::a('<span class="glyphicon glyphicon-eye-open">', Url::to(['sys-org/view', 'id' => $model->id]));
					},
					'update' => function($url, $model, $key){
						return Html::a('<span class="glyphicon glyphicon-pencil">', Url::to(['sys-org/update', 'id' => $model->id]));
					}
			]
				
			],
		],
	]); ?>

</div>