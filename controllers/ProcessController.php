<?php


namespace app\controllers;


use yii\httpclient\Client;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class ProcessController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'start' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionOne()
    {
        //   $this->enableCsrfValidation = false;

        $request = Yii::$app->request;

        $url = $request->post('url');

        $client = new Client();

        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url);


        $data = $request->send();

        if ($data->isOK) {
            $results = [
                'status' => 'SUCCESS',
                'results' => [
                    'status' => $data->getStatusCode(),
                  //  'headres' => $data->getHeaders(),
                ],
            ];


            $codes = [];
            //echo "<pre>";
            //die(var_dump($data->getHeaders()["http-code"]));


                foreach ($data->getHeaders() as $code){
                    $codes[] = $code;
                }

                $results['results']['codes'] = $codes;

        } else {
            $results = [
                'status' => 'ERROR',
                'message' => $data->content
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $results;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'one') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
}