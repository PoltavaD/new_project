<?php

namespace app\controllers;

use Yii;
use app\models\Files;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;


class OrderController extends Controller
{
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->pdfFiles = UploadedFile::getInstances($model, 'pdfFiles');
            if ($model->upload()) {
                return $this->render('upload', ['model' => $model]);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionShow()
    {
        $session = Yii::$app->session;
        if ($session->get('role') == 2) {
            $files = Files::find()->where(['status' => 1])->all();
            return $this->render('showordersforlawyer', ['files' => $files]);
        } else {
            $files = Files::find()->where(['user_id' => ($session->get('id' ))])->all();
            return $this->render('showorders', ['files' => $files]);
        }
    }

    public function actionTakeWork()
    {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        if ($session->get('role') == 2) {
            $files = Files::find()->where('id=:id',[':id' => $id])->all();
//        echo '<pre>';
//        print_r($files);
//        exit();

            $files->setAttributes($files->attributes);
            $files->status = 2;
            $files->save();
            $files = Files::find()->where('status == 1')->all();
            return $this->render('showordersforlawyer', ['files' => $files]);
        }

    }

    public function actionTest()
    {
        echo '<pre>';
        print_r();
        exit();

    }

}
