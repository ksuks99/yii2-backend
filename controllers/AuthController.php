<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Login;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use app\models\User;

class AuthController extends Controller
{
  public function init()
  {
      parent::init();
      \Yii::$app->user->enableSession = false;
  }

  public function behaviors()
  {
    return ArrayHelper::merge([
      [
          'class' => Cors::class,
          'cors' => [
              'Origin' => ['*'],
              'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
              'Access-Control-Request-Headers' => ['*'],
          ],
      ],
    ], parent::behaviors());
  }

  public function actionLogin()
  {
    \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

    if(!$this->request->isPost) {
      return "Not post";
    }

    $isGuest = Yii::$app->user->isGuest;

    $data = $this->request->post();
    $username = $data["username"];
    $password = $data["password"];

    $user = User::findByUsername($username);

    if ($user === null || !$user->validatePassword($password)) {
      return "Invalid username/password";
    }
    return $user;
  }


  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->goHome();
  }

  public function actionTest()
  {
    // var_dump(Yii::$app->components);
    // var_dump(Yii::$app->errorHandler); die;
    \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
    return "ok";
  }
}
