<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\RefOrgType;
use yii\bootstrap\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$types = ArrayHelper::map(RefOrgType::find()->all(), 'id', 'type');

?>

<br>
<div class="sys-org-form">
	
	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($sys_org, 'name')->textInput()->label('Имя организации') ?>

	<?= $form->field($sys_org, 'bin')->textInput()->label('БИН') ?>
	
	<?= $form->field($sys_org, 'type')->dropdownList($types, [
		'disabled' => true
	])->label('Тип организации') ?>

	<div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

	<?php Pjax::begin() ?>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' => 'Нет дочерних организаций',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'name', 'label' => 'Имя организации'],
            ['attribute' => 'ref_org_type.type', 'label' => 'Тип организации', 'filter' => $types],
            ['attribute' => 'bin', 'label' => 'БИН'],

            [
            	'class' => 'yii\grid\ActionColumn', 
            	'template' => '{delete}',
            	'buttons' => [
            		'delete' => function($url, $model, $key){
            			return Html::a('<span class="glyphicon glyphicon-trash">', Url::to(['sys-org/delete-rel', 'id' => $model->id]), [
            				'data' => [
            					'confirm' => 'Все зависимые связи будут удалены, вы в этом уверены?'
            				]
            			]);
            		}
            	]
            ],
        ],
    ]); ?>

	<?php Pjax::end() ?>

</div>