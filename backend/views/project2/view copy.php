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
                'template' => '{view}&nbsp{update}&nbsp{delete}',   //{view}&nbsp;
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                      </svg>', $url);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                      </svg>', '#', [
                            'id' => 'activity-index-link',
                            'title' => Yii::t('app', 'Update'),
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'data-url' => Url::to(['task/update', 'id' => $model->id]),
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                      </svg>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', '¿Desea eliminar este elemento?'),
                            'data-method' => 'post',
                        ]);
                    },
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'view') {
                            return Html::a('Action', $url);
                        }
                        if ($action == 'update') {
                            return Html::a('Action', $url);
                        }
                        if ($action == 'delete') {
                            return Html::a('Action', $url);
                        }
                    }
                ]
            ],  // fin ActionColumn
        ],
    ]); ?>
    <?php Pjax::end() ?>

    <?php
    $this->registerJs(
        "$('#activity-index-link').on('click', function() {
            $.get(
                $(this).data('url'),
                function (data) {
                    $('.modal-body').html(data);
                    $('#modal').modal();
                }
            );
    });",
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