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

use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBasicAuth;

class ApiController extends Controller // /api
{
  public function init()
  {
      parent::init();
      \Yii::$app->user->enableSession = false;
  }

  public function behaviors()
  {
    $behaviors = ArrayHelper::merge([
      [
          'class' => Cors::class,
          'cors' => [
              'Origin' => ['*'],
              'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
              'Access-Control-Request-Headers' => ['*'], // ['Content-Type', 'Authorization'],
          ],
      ],
    ], parent::behaviors());
    $behaviors['authenticator'] = [
      'class' => HttpBasicAuth::class,
    ];
    return $behaviors;
  }

  public function actionLogin()
  {
    return "hello";
  }

  public function actionTest() // api/test
  {
    $response = \Yii::$app->response;
    return [
      "isSuccessful" => $response->isSuccessful, 
      "statusCode" => $response->statusCode, 
      "version" => $response->version
    ];
  }

  public function actionGet() // api/get
  {
    $request = Yii::$app->getRequest();
    $id = $request->get('id', null);
    if ($id === null) { // 0 == null
      // return Note::findBySql("SELECT * FROM note")->all();
      return Note::find()->all();
    }
    return $this->findModel(intval($id));
  }

  public function actionInsert() // api/insert
  {
    $data = $this->request->post();

    if (Note::findOne($data["id"]) !== null) {
      return ["error" => true, "id" => $data["id"]];
    }
    $model = new Note();
    $model->attributes = $data;
    $model->save();

    return ["error" => false, "id" => $model->id];
  }

  public function actionDelete($id) // api/delete
  {
    $model = Note::findOne($id);

    if ($model === null) {
      return ["deleted" => false, "id" => intval($id)];
    }
      
    $model->delete();
    return ["deleted" => true, "id" => intval($id)];
  }

  public function actionUpdate($id) // api/update
  {
    
    $model = Note::findOne($id);

    if ($model === null) {
      return ["updated" => false, "id" => intval($id)];
    }

    $data = $this->request->post();
    $model->attributes = $data;
    $model->save();

    return ["updated" => true, "id" => intval($id)];;
  }

  public function beforeAction($action)
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
    // CORS works
    // Yii::$app->response->headers->set('Access-Control-Allow-Origin', 'http://localhost:8081');
    // Yii::$app->response->headers->set("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
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