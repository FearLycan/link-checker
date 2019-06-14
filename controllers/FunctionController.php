<?php


namespace app\controllers;


use yii\web\Controller;

class FunctionController extends Controller
{
    public function actionOne()
    {
        return $this->render('one');
    }

    public function actionTwo()
    {
        return $this->render('two');
    }

    public function actionThree()
    {
        return $this->render('three');
    }
}