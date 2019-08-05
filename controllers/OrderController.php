<?php

namespace app\controllers;

use Yii;
use app\models\Files;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\Orders;
use app\models\UploadOrderForm;

class OrderController extends Controller
{

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->pdfFiles = UploadedFile::getInstances($model, 'pdfFiles');
            if ($model->upload()) {
                $session = Yii::$app->session;
                $files = Files::find()->where(['user_id' => ($session->get('id' ))])->all();
                return $this->render('showorders', ['files' => $files]);//
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionShow()
    {
        $session = Yii::$app->session;
        if ($session->get('role') == 2) {
            $files = Files::find()->where(['status' => 1])->all();
            return $this->render('showordersforlawyer', ['files' => $files,]);
        } else {
            $files = Files::find()->where(['user_id' => ($session->get('id' ))])->all();
            return $this->render('showorders', ['files' => $files, ]);
        }
    }

    public function actionTakeWork()
    {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        if ($session->get('role') == 2) {
            $files = Files::find()->where('id=:id', [':id' => $id])->one();
            if ($files) {
                $newOrder = new Orders();
                $newOrder->user_id = $session->get('id');
                $newOrder->pdf_name = $files->pdf_name;
                $newOrder->save_name = $files->save_name;
                $newOrder->status = 2;
                $newOrder->save();
                $files->setAttributes($files->attributes);
                $files->status = 2;
                $files->order_id = Yii::$app->db->getLastInsertID();
                $files->save();

                $files = Files::find()->where(['status' => 1])->all();
                return $this->render('showordersforlawyer', ['files' => $files]);
            }

        }else {
            $this->redirect('/auth/index');
        }
    }

    public function actionWork()
    {
        $session = Yii::$app->session;
        if ($session->get('role') == 2) {
            $files = Orders::find()->where(['status' => [2,3], 'user_id' => $session->get('id'),])->all();
            return $this->render('ordersinwork', ['files' => $files]);
        } else {
            $files = Files::find()->where(['user_id' => ($session->get('id' ))])->all();
            return $this->render('showorders', ['files' => $files]);
        }
    }

    public function actionDownload($id)
    {

        $session = Yii::$app->session;
        if (!$session->get('role') == 2) {
            $files = Files::find()->where(['user_id' => ($session->get('id' ))])->all();
            return $this->render('showorders', ['files' => $files]);
        } else {
            $file = Orders::find()->where(['id' => $id, 'user_id' => $session->get('id'),])->one();
        }
        if ($file) {
            $path = './uploads/' . $file->save_name[0] . '/' . $file->save_name[1] . '/' . $file->save_name;
        }

        if (file_exists($path)) {

            header("Cache-Control: public");
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . $file->pdf_name);
            header('Content-Type: octet-stream');
            header('Content-Transfer-Encoding: binary');
            readfile($path);
        }

    }

    public function actionSendOrder()
    {

        $session = Yii::$app->session;
        if ($session->get('role') == 1) {
            $this->redirect('/auth/index');
        } else {
            $id = Yii::$app->request->get('id');
            $Order = Orders::find()->where('id=:id', [':id' => $id])->one();
            if ($Order) {
                $Order->setAttributes($Order->attributes);
                $Order->status = 3;
                $Order->save();
                $model = new UploadOrderForm();
                return $this->render('/order/uploadOrder', ['model' => $model, 'Order' => $Order]);
            } else {
                $files = Orders::find()->where(['status' => [2,3], 'user_id' => $session->get('id'),])->all();
                return $this->render('ordersinwork', ['files' => $files, ]);
            }
        }

    }

    public function actionOrderUpload()
    {
        $model = new UploadOrderForm();

        if (Yii::$app->request->isPost) {
            $model->pdfOrder = UploadedFile::getInstance($model, 'pdfOrder');
            if ($model->upload()) {
                $session = Yii::$app->session;
                $files = Files::find()->where(['user_id' => ($session->get('id' ))])->all();
                return $this->render('showorders', ['files' => $files]);//
            }
        }

        return $this->render('uploadOrder', ['model' => $model, 'Order' => $Order]);
    }

    public function actionTest()
    {

        return $this->render('test');
        echo '<pre>';
        print_r($pdfOrder);
        exit();
    }

}
