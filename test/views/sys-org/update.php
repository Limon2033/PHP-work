<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Country */

$this->title = 'Обновить организацию: ' . $sys_org->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $sys_org->name, 'url' => ['view', 'id' => $sys_org->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="sys-org-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-update', [
        'sys_org' => $sys_org,
        'sys_org_rel' => $sys_org_rel,
        'sys_org_rel_new' => $sys_org_rel_new,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
