<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LogForm;
use app\models\RegForm;
use app\models\Users;
use yii\helpers\Url;

class AuthController extends Controller
{
    public function actionIndex()
    {
        $model = new LogForm();

        if($model->load(\Yii::$app->request->post())) {
            $user = Users::find()->asArray()->where(['email' => ($_POST['LogForm']['email'])])->one();
            if (!empty($user)) {
                if (password_verify($_POST['LogForm']['pass'], $user['pass'])) {
                    $session = Yii::$app->session;
                    $session->open();
                    $session->set('id', $user['id']);
                    $session->set('role', $user['role']);

                    if ($session->get('role' ) == 1) {
                        Yii::$app->response->redirect(Url::to('order/show'));
                    } elseif ($session->get('role' ) == 2) {
                        Yii::$app->response->redirect(Url::to('order/show'));
                    }
                } else {
                    return $this->render('auth', compact('model'));
                }
            }
        }

        return $this->render('auth', compact('model'));
    }

    public function actionRegistration()
    {
        $model = new RegForm();

        if($model->load(\Yii::$app->request->post())){

            if ($model->validate()) {
                Yii::$app->session->setFlash('success', 'ok');
                $newUser = new Users();
                $newUser->setAttributes($model->attributes);
                $newUser->pass = password_hash(($_POST['RegForm']['pass']), PASSWORD_DEFAULT);
                if (!$newUser->save()) {
                    $model->addErrors($newUser->errors);

                    echo '<pre>';
                    print_r($newUser->errors);
                    exit();
                } else {
                    $session = Yii::$app->session;
                    $session->open();
                    $session->set('id', Yii::$app->db->getLastInsertID());
                    $session->set('role', $_POST['RegForm']['role']);
                    if ($session->get('role' ) == 1) {
                        Yii::$app->response->redirect(Url::to('/order/upload'));
                    } elseif ($session->get('role' ) == 2) {
                        Yii::$app->response->redirect(Url::to('/order/show'));
                    }
                }
            }
        }

        return $this->render('reg', compact('model'));
    }

    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->destroy();
        return $this->goHome();
    }
}
