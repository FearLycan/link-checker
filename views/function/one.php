<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forms\OneForm */
$this->title = 'Function One';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="function-one">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_forms/one', [
        'model' => $model,
    ]) ?>
</div>