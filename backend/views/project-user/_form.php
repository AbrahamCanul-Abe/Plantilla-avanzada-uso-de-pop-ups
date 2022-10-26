<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\widgets\Typeahead; 
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model backend\models\ProjectUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'project_id')->textInput() ?> -->

    <!-- <?= $form->field($model, 'user_id')->textInput() ?> -->
    <?php
    echo $form->field($model, 'userEmail')->widget(Typeahead::classname(), [
    'options' => ['placeholder' => 'Type user email ...'],
    'pluginOptions' => ['highlight'=>true],
    'dataset' => [
            [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                'display' => 'value',
                'remote' => [
                    'url' => Url::to(['project-user/user-list']) . '&q=%QUERY',
                    'wildcard' => '%QUERY'
                ]
            ]
        ]
    ]);
?>

    <!-- <?= $form->field($model, 'role_id')->textInput() ?> -->
    <?= $form->field($model, 'role_id')->dropDownList($model->getRolesList(), ['prompt' => 'Select...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
