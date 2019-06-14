<?php


namespace app\controllers;


use app\models\forms\OneForm;
use app\models\Links;
use Yii;
use yii\web\Controller;

class FunctionController extends Controller
{
    public function actionOne()
    {
        $model = new OneForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->links = json_encode($model->extractLinks());
            $model->save();

            return $this->redirect(['result', 'id' => $model->id]);
        }

        return $this->render('one', [
            'model' => $model
        ]);
    }

    public function actionResult($id)
    {
        $model = Links::findOne($id);

        $links = json_decode($model->links);

        return $this->render('result', [
            'links' => $links
        ]);
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