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
    <p>
        1. Podajemy listę adresów www w polu tekstowym (jeden na linię) i zostają wyświetlone zwracane przez nie statusy
        HTTP (200, 301, 302 itd). Jeśli adres przekierowuje na coś to trzeba wyświetlić na co.
    </p>
    <?= $this->render('_forms/one', [
        'model' => $model,
    ]) ?>
</div>