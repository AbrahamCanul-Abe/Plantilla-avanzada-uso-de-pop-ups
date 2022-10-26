<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;

use yii\bootstrap4\Modal;  //Para ventana Modal
use yii\helpers\Url;

use backend\models\Task;

use yii\web\View;

use yii\widgets\Pjax;

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

        <?= Html::a(
            'Asignar Usuarios',
            ['project-user/create', 'project_id' => $model->id],
            ['class' => 'btn btn-info']
        ) ?>
    </p>

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

    <h3 style="text-align: center;color:brown;">Tareas del Proyecto </h3>

    <?= Html::a('Create Tarea', '#', [
        'id' => 'activity-index-link',
        'class' => 'btn btn-success',
        'data-toggle' => 'modal',
        'data-target' => '#modal',
        'data-url' => Url::to(['task/create', 'project_id' => $model->id]),
        'data-pjax' => '0',
    ]); ?>

    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'task-grid',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description:ntext',
            'project_id',
            'status_id',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',


            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'task',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                      </svg>', '#', [
                            'id' => 'activity-index-link2',
                            'title' => Yii::t('app', 'Update'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'data-url' => Url::to(['task/update', 'id' => $model->id]),
                            'data-pjax' => '0',
                        ]);
                    },
                ]
            ],  // fin ActionColumn
        ],
    ]); ?>
    <?php Pjax::end() ?>

    <?php
    $this->registerJs(
        "$('#activity-index-link').on('click', function() {
            alert('ENTROOOO11111')
            $.get(
                $(this).data('url'),
                function (data) {
                    $('.modal-body').html(data);
                    $('#modal').modal();
                }
            );
    });

    $('#activity-index-link2').on('click', function() {
        alert('ENTROOOO222')
        $.get(
            $(this).data('url'),
            function (data) {
                $('.modal-body').html(data);
                $('#modal').modal();
            }
        );
});

    ",
        View::POS_READY,
        'my-button-handler'
    ); ?>

    <?php
    Modal::begin([
        'id' => 'modal',
        'title' => '<h4 class="modal-title">Completar</h4>',
        'footer' => '<a href="#"  class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</a>',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
    ]);
    echo "<div id='modalContent'><div align='center'><img src='../../imagenes/cargando.gif'></div></div>";

    Modal::end();
    ?>

</div>