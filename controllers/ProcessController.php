<?php


namespace app\controllers;


use app\models\Links;
use Symfony\Component\DomCrawler\Crawler;
use yii\db\Exception;
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
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $url = $request->post('url');

        $client = new Client();

        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url);

        try {
            $data = $request->send();
        } catch (\yii\httpclient\Exception $exception) {
            return [
                'status' => 'ERROR',
                'message' => $exception->getMessage()
            ];
        }


        if ($data->isOK) {
            $results = [
                'status' => 'SUCCESS',
                'results' => [
                    'status' => $data->getStatusCode(),
                ],
            ];

            $codes = [];

            $header = $data->getHeaders()->toArray();

            foreach ($header["http-code"] as $code) {
                $codes[] = $code;
            }

            $results['results']['codes'] = $codes;

            if (isset($header['location'])) {
                $locations = [];
                foreach ($header["location"] as $location) {
                    $locations[] = $location;
                }

                $results['results']['locations'] = $locations;
            }

        } else {
            $results = [
                'status' => 'ERROR',
                'message' => $data->content
            ];
        }


        return $results;
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionTwo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $url = $request->post('url');
        $key = $request->post('key');
        $link = $request->post('link');


        //[{"url":"https:\/\/getbootstrap.com\/docs\/3.4\/components\/","key":"CSS","link":"https:\/\/getbootstrap.com\/docs\/3.4\/css\/"}]

        $url = 'https://getbootstrap.com/docs/3.4/components/';
        $key = 'CSS';
        $link = '/docs/3.4/css/';

        $client = new Client();

        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(trim($url));

        try {
            $data = $request->send();
        } catch (\yii\httpclient\Exception $exception) {
            return [
                'status' => 'ERROR',
                'message' => $exception->getMessage() . 'URL: ' . $url,
            ];
        }


        if ($data->isOK) {
            $results = [
                'status' => 'SUCCESS',
                'results' => [
                    'status' => $data->getStatusCode(),
                ],
            ];

            $codes = [];

            $header = $data->getHeaders()->toArray();

            foreach ($header["http-code"] as $code) {
                $codes[] = $code;
            }

            $results['results']['codes'] = $codes;

            if (isset($header['location'])) {
                $locations = [];
                foreach ($header["location"] as $location) {
                    $locations[] = $location;
                }

                $results['results']['locations'] = $locations;
            }

            //key link
            $crawler = new Crawler($data->content);

            $a = $crawler
                ->filterXpath("//a[contains(@href,'" . trim($link) . "')]");
           // die(var_dump("//a[contains(@href,'" . trim($link) . "')]"));
            // die(var_dump(strtolower($a->text()) . ' '. strtolower($link['key'])));
            $key = strtolower($key);
            $text = strtolower($a->text());

            if (preg_match("/{$key}/i", $text)) {
                $results['results']['key'] = 'was found - ' . $key;
            } else {
                $results['results']['key'] = 'was not found - ' . $key;
            }


            if ($a->extract('nofollow')[0]) {
                $results['results']['nofollow'] = true;
            } else {
                $results['results']['nofollow'] = false;
            }

        } else {
            $results = [
                'status' => 'ERROR',
                'message' => $data->content
            ];
        }

        return $results;
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionThree()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $url = $request->post('url');
        //$key = $request->post('key');
        $link = $request->post('link');

        $client = new Client();

        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl(trim($url));

        try {
            $data = $request->send();
        } catch (\yii\httpclient\Exception $exception) {
            return [
                'status' => 'ERROR',
                'message' => $exception->getMessage() . 'URL: ' . $url,
            ];
        }


        if ($data->isOK) {
            $results = [
                'status' => 'SUCCESS',
                'results' => [
                    'status' => $data->getStatusCode(),
                ],
            ];

            $codes = [];

            $header = $data->getHeaders()->toArray();

            foreach ($header["http-code"] as $code) {
                $codes[] = $code;
            }

            $results['results']['codes'] = $codes;

            if (isset($header['location'])) {
                $locations = [];
                foreach ($header["location"] as $location) {
                    $locations[] = $location;
                }

                $results['results']['locations'] = $locations;
            }

            //link
            $crawler = new Crawler($data->content);

            $a = $crawler
                ->filterXpath("//a[contains(@href,'" . trim($link) . "')]");

            if(!empty($a->text())){
                $results['results']['text'] = 'was found - ' . $a->text();
            }else{
                $results['results']['text'] = 'was not found';
            }

        } else {
            $results = [
                'status' => 'ERROR',
                'message' => $data->content
            ];
        }

        return $results;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['one', 'two', 'three'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
}