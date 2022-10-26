<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView; 

/* @var $this yii\web\View */
/* @var $model backend\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('Assign User', ['project-user/create',
                    'project_id' => $model->id],
                   ['class' => 'btn btn-info']) ?>
    </p>

    <!-- <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'description:ntext',
            'created_at',
            'updated_at',
            [
                'label' => 'Creado por',
                'value' => $model->getUserName($model->created_by)
            ],
            [
                'label' => 'Actualizado por',
                'value' => $model->getUserName($model->updated_by)
            ],
        ],
    ]) ?>

    <h1>Tareas del Proyecto </h1>
    <?= Html::a('Create Task', ['task/create',
                'project_id' => $model->id],
               ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'description:ntext',
                'project_id',
                'status_id',
                //'created_at',
                //'updated_at',
                //'created_by',
                //'updated_by',

                ['class' => 'yii\grid\ActionColumn', 'controller' => 'task'], 
            ],
        ]); ?>

</div>
