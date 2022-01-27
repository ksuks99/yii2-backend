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
  public $enableCsrfValidation = false;

  public function actionTest() // api/test
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
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
    $data = $this->request->post();

    $model = new Note();
    $model->attributes = $data;
    $model->save();

    return $model;
  }

  public function actionDelete($id)
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
    $model = Note::findOne($id);

    if ($model === null) {
      return ["deleted" => false, "id" => intval($id)];
    }
      
    $model->delete();
    return ["deleted" => true, "id" => intval($id)];
  }

  public function actionUpdate($id)
  {
    \Yii::$app->response->format = Response::FORMAT_JSON;
    $model = Note::findOne($id);

    if ($model === null) {
      return ["updated" => false, "id" => intval($id)];
    }

    $data = $this->request->post();
    $model->attributes = $data;
    $model->save();

    return $data;
  }

  protected function findModel($id)
  {
      if (($model = Note::findOne($id)) !== null) {
          return $model;
      }

      throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }
}