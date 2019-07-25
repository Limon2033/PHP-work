<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\RefOrgType;
use app\models\SysOrg;
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

	<?php 

	if($sys_org->type == 2){ // Комитет

		echo '<h3>Курирующая организация</h3>';

		echo $form->field($sys_org_rel_new, 'parent_id')->dropdownList(ArrayHelper::map(SysOrg::find()
            		->where(['type' => 1])
            		->all(), 'id', 'name'), [
        		'id' => 'min-id-form',
        		'prompt' => 'министерство...',
    		])->label('Министерство');	
	}

	else if($sys_org->type == 3){ // Управление

		echo '<h3>Курирующая организация</h3>';

		echo Html::dropDownList('min', null, ArrayHelper::map(SysOrg::find()
            		->where(['type' => 1])
            		->all(), 'id', 'name'), [
        		'id' => 'min-id-html',
        		'prompt' => 'министерство...',
        		'onchange' => 'if($(this).val() == 0){
           			$.post( "'.Yii::$app->urlManager->createUrl('sys-org/reform?type=1').'", function( data ) {
                 	 	$( "select#min-id-html" ).html( data );
               			})
       	 		}
        		else{
            		$.post( "'.Yii::$app->urlManager->createUrl('sys-org/organizate?relation=parent_org&value=parent_id&id=').'"+$(this).val(), function( data ) {
                  		$( "select#kom-id" ).html( data );
                		})
        		}'
    		]);

		echo $form->field($sys_org_rel_new, 'parent_id')->dropdownList(ArrayHelper::map(SysOrg::find()
					->where(['type' => 2])
					->all(), 'id', 'name'), [
				'id' => 'kom-id',
				'prompt' => 'комитет...',
				'onchange' => 'if($(this).val() == 0){
					var $url = "sys-org/reform?type=2"
					var $select = "select#kom-id"
				}
				else{
					var $url = "sys-org/organizate?relation=child_org&value=child_id&id="+$(this).val()
					var $select = "select#min-id-html";
				}
				$.post( "'.Yii::$app->urlManager->createUrl('').'"+$url, function( data ) {
				  		$( $select ).html( data );
						})'
			])->label('Комитет');
	}

	?>

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