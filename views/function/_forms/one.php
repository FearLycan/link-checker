<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\forms\OneForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="one-form">
    <div class="row">
        <?php Pjax::begin(); ?>
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-12">
            <?= $form->field($model, 'links')->textarea(['rows' => '6']) ?>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
</div>