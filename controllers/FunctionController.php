<?php


namespace app\controllers;


use app\models\forms\OneForm;
use app\models\forms\ThreeForm;
use app\models\forms\TwoForm;
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

    public function actionResultTwo($id)
    {
        $model = Links::findOne($id);

        $links = json_decode($model->links);

        return $this->render('rtwo', [
            'links' => $links,
            'id' => $id
        ]);
    }

    public function actionResultThree($id)
    {
        $model = Links::findOne($id);

        $links = json_decode($model->links);

        return $this->render('rthree', [
            'links' => $links,
            'id' => $id
        ]);
    }

    public function actionTwo()
    {
        $model = new TwoForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->links = json_encode($model->extractLinks());
            $model->save();

            return $this->redirect(['result-two', 'id' => $model->id]);
        }

        return $this->render('two',[
            'model' => $model
        ]);
    }

    public function actionThree()
    {
        $model = new ThreeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->links = json_encode($model->extractLinks());
            $model->save();

            return $this->redirect(['result-three', 'id' => $model->id]);
        }

        return $this->render('three',[
            'model' => $model
        ]);
    }
}