<?php

namespace app\controllers;

use linslin\yii2\curl;
use Yii;

class ApiController extends \yii\rest\Controller
{
    public $ContactForm;
    /**
     * Yii action controller
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * List of allowed domains.
     * Note: Restriction works only for AJAX (using CORS, is not secure).
     *
     * @return array List of domains, that can access to this API
     */
    public static function allowedDomains() {
        return [
            // '*',                        // star allows all domains
            'http://localhost:3000',
            'http://localhost:3006',
            'http://localhost:8080',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
     {
         return [
             'corsFilter' => [
                 'class' => \yii\filters\Cors::class,
                 'cors' => [
                     // restrict access to
                     'Access-Control-Allow-Origin' => ['*'],
                 ],
    
             ],
         ];
    }

    public function actionIndex()
    {
        // $model->load(Yii::$app->getRequest()->getBodyParams());
        $_POST = Yii::$app->getRequest()->getBodyParams();
        // print_r($_POST['city']);
        // die;
        if(!empty($_POST)){
            
            if(!empty($_POST['city'])){
                $city = $_POST['city'];
            }else{
                $data = array(
                    'status_code' => 401,
                    'message' => 'No city input',
                );
                echo json_encode($data);
                die;
            }
        
            //Init curl
            $curl = new curl\Curl();

            $url = 'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&units=metric&appid=19fca441d7e8f76a6a22447e44414b31';
            // $url = 'https://api.openweathermap.org/data/2.5/weather?q=meerut&units=metric&appid=19fca441d7e8f76a6a22447e44414b31';
            $response = $curl->get($url);
            $data = array(
                'status_code' => 200,
                'result' => json_decode($response),
            );
            echo json_encode($data);
            die;
        }else{
            $data = array(
                'status_code' => 400,
                'message' => 'Bad Request',
            );
            echo json_encode($data);
            die;
        }
    }

}
