<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\RefOrgType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Country */

$this->title = $sys_org->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$types = ArrayHelper::map(RefOrgType::find()->all(), 'type', 'type');

?>

<div class="sys-org-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $sys_org->id], ['class' => 'btn btn-primary']) ?>
    </p>



    <?= DetailView::widget([
        'model' => $sys_org,
        'attributes' => [
            'name',
            'ref_org_type.type',
            'bin',
        ]
    ]) ?>

    <?= DetailView::widget([
        'model' => $sys_org_rel,
        'attributes' => [
            [
                'label' => 'Имя курирующей организации',
                'value' => function($sys_org_rel){
                    if(empty($sys_org_rel)){
                        return "-";
                    }
                    else{
                        return $sys_org_rel->parent_org->name;
                    }
                }
            ],
            [
                'label' => 'Статус управления',
                'value' => function($sys_org_rel){
                    if($sys_org_rel->end_date <= date("Y-m-d")){
                        return "неактивный";
                    }
                    else{
                        return "активный";
                    }
                }
            ],
            [
                'label' => 'Дата начала управления',
                'value' => function($sys_org_rel){
                    if($sys_org_rel->start_date != null){
                        return $sys_org_rel->start_date;
                    }
                    else{
                        return "-";
                    }
                }
            ],
            [
                'label' => 'Дата завершения управления',
                'value' => function($sys_org_rel){
                    if($sys_org_rel->end_date != null){
                        return $sys_org_rel->end_date;
                    }
                    else{
                        return "-";
                    }
                }
            ],
        ]
    ]) ?>
    
    

    <h3>Подчиненные организации</h3>
    <br>

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

            ['class' => 'yii\grid\ActionColumn', 'template' => ''],
        ],
    ]); ?>

    <?php Pjax::end() ?>

</div>
