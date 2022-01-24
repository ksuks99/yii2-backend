<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property string $ful_name
 * @property string $login
 * @property string $email
 * @property string $password
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ful_name', 'login', 'password'], 'required'],
            [['id'], 'integer'],
            [['ful_name'], 'string', 'max' => 700],
            [['login'], 'string', 'max' => 110],
            [['email', 'password'], 'string', 'max' => 100],
            [['id'], 'unique'], // show ID "123" has already been taken.
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ful_name' => 'Ful Name',
            'login' => 'Login',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
