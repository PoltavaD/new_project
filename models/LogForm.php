<?php
/**
 * Created by PhpStorm.
 * User: Poltava
 * Date: 20.07.2019
 * Time: 5:38
 */

namespace app\models;
use yii\base\Model;


class LogForm extends Model
{
    public $email;
    public $pass;

    public function rules()
    {
        return [
            [['email','pass',], 'required'],
            [['email','pass',], 'trim'],
        ];
    }

}
