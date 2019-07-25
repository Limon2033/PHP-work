<?php

use yii\helpers\Html;

$this->title = 'Добавить организацию';
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="sys-org-create">
	
	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form-create', [
		'sys_org' => $sys_org,
		'sys_org_rel' => $sys_org_rel,
	]) ?>

</div>