<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\RefOrgType;
use yii\helpers\Url;
use yii\bootstrap\Html;

$types = ArrayHelper::map(RefOrgType::find()->all(), 'id', 'type');

?>

<br>
<div class="sys-org-form">

	<style type="text/css">
		.field-min-id-form, #min-id-html, .field-kom-id, .kurator{
			display: none;
		}
	</style>
	
	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($sys_org, 'name')->textInput()->label('Имя организации') ?>

	<?= $form->field($sys_org, 'bin')->textInput()->label('БИН') ?>
	
	<?= $form->field($sys_org, 'type')->dropdownList($types, [
        'id' => 'type-id',
        'onchange' => '

			if($(this).val() == 3){
				$("#kom-id").prop("disabled", false);
				$.post( "'.Yii::$app->urlManager->createUrl('sys-org/reform?type=1').'", function( data ) {
                 	 $( "select#min-id-html" ).html( data );
               		})
               	$.post( "'.Yii::$app->urlManager->createUrl('sys-org/reform?type=2').'", function( data ) {
				  $( "select#kom-id" ).html( data );
				})
				$("#min-id-html, .field-kom-id, .kurator").show();

				$(".field-min-id-form").hide();
				$(".field-min-id-form").prop("disabled", true);
			}
			else if($(this).val() == 2){
				$("#min-id-form").prop("disabled", false);
				$.post( "'.Yii::$app->urlManager->createUrl('sys-org/reform?type=1').'", function( data ) {
                		 $( "select#min-id-form" ).html( data );
               	 })
				$(".field-min-id-form, .kurator").show();

				$(".field-kom-id, #min-id-html").hide();
				$("#kom-id").prop("disabled", true);
			}
			else{
				$(".field-min-id-form, #min-id-html, .field-kom-id, .kurator").hide();
				$("#min-id-form, #kom-id").prop("disabled", true);
			}
        ',
    ])->label('Тип организации') ?>

	<h3 class="kurator">Курирующая организация</h3>

	<?= Html::dropDownList('min', null, ArrayHelper::map($sys_org->find()
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
    	]); ?>

    <?= $form->field($sys_org_rel, 'parent_id')->dropdownList(ArrayHelper::map($sys_org->find()
            	->where(['type' => 1])
            	->all(), 'id', 'name'), [					
        	'id' => 'min-id-form',
        	'prompt' => 'министерство...',
        	'disabled' => true,
    	])->label('Министерство') ?>

	<?= $form->field($sys_org_rel, 'parent_id')->dropdownList(ArrayHelper::map($sys_org->find()
			->where(['type' => 2])
			->all(), 'id', 'name'), [
		'id' => 'kom-id',
		'prompt' => 'комитет...',
		'disabled' => true,
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
	])->label('Комитет'); ?>

	<div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

	<?php 
    $script = <<< JS
    $("#type-id").val(0);

    JS;
    $this->registerJs($script);
    ?>

</div>