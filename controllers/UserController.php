<?php

namespace app\controllers;

use app\models\User;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller // user/
{
  public function actionExist($id) // user/view?id=100
  {
    // /web/user/exist?id=101
    // User with id = 101 exist
    return User::findIdentity($id) == null ? 
    "User don't exist" : 'User with id = '. $id . ' exist';
  }
}