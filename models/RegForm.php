<?php
/**
 * Created by PhpStorm.
 * User: Poltava
 * Date: 20.07.2019
 * Time: 5:13
 */

namespace app\models;

use yii\base\Model;

class RegForm extends Model
{
    public $name;
    public $email;
    public $pass;
    public $role;

    public function rules()
    {
        return [
            [['name','email','pass','role',], 'required'],
            [['name','email','pass',], 'trim'],
            ['email', 'email'],
            ['pass', 'string', 'min' => 6],
            ['email','unique', 'targetClass' => Users::class],
        ];
    }

}