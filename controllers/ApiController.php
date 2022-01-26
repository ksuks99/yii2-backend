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

use app\models\Note;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ApiController extends Controller // /api
{
  // public $serializer = [
  //   'class' => 'yii\rest\Serializer',
  //   'collectionEnvelope' => 'items',
  // ];

  public function actionTest() // api/test
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
    // $model = new \app\models\ContactForm;
    $response = \Yii::$app->response;
    throw new HttpException(404, 'The requested Item could not be found.');
    return [
      "isSuccessful" => $response->isSuccessful, 
      "statusCode" => $response->statusCode, 
      "version" => $response->version
    ];
  }

  public function actionGet() // api/get
  {
    // convert array to JSON
    \Yii::$app->response->format = Response::FORMAT_JSON;
    $request = Yii::$app->getRequest();
    // $myData=(object)$request->bodyParams['message'];
    $id = $request->get('id', null);
    if ($id === null) { // 0 == null
      // return Note::findBySql("SELECT * FROM note")->all();
      return Note::find()->all();
    }
    return $this->findModel(intval($id));
  }

  public function actionInsert() // api/insert
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
    // $request = Yii::$app->getRequest();
    $request = $this->request;
    $post = $request->post();

    return $post;
  }

  public function beforeAction($action)
  {
    if ($action->id === 'insert') {
      
    }
    return parent::beforeAction($action);
  }

  protected function findModel($id)
  {
      if (($model = Note::findOne($id)) !== null) {
          return $model;
      }

      throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }
}