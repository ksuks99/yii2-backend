<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
// use yii\rest\ActiveController; // The "modelClass" property must be set.
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class ApiController extends Controller // /api
{
  // public $serializer = [
  //   'class' => 'yii\rest\Serializer',
  //   'collectionEnvelope' => 'items',
  // ];

  public function actionTest() { // api/test
    return 'ok';
  }

  public function actionGet() { // api/get
    return ['id1' => 100, 'id2' => 200];
  }

  public function actionOther() { // api/other
    return $this->render('index');
  }

  // convert array to JSON
  public function beforeAction($action)
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
    return parent::beforeAction($action);
  }
}