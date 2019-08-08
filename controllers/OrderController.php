<?php

namespace app\controllers;

use Yii;
use app\models\Files;
use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\Orders;
use app\models\UploadOrderForm;
use yii\helpers\Url;

class OrderController extends Controller
{

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->pdfFiles = UploadedFile::getInstances($model, 'pdfFiles');
            if ($model->upload()) {
                $this->redirect('/order/show');
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

                Yii::$app->response->redirect(Url::to(['order/order-upload', 'pdf_name' => $Order->pdf_name,
                    'order_id' => $Order->id] ));

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
                $this->redirect('/order/work');
            }
        }

        return $this->render('uploadOrder', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $session = Yii::$app->session;
        $file = Files::find()->where(['id' => $id,])->one();

        if ( !$file ) {
            Yii::$app->session->setFlash('Error', 'Файл не существует!');
            return $this->redirect('/order/ready-orders/');
        } else {
            $path = './uploads/' . $file->save_name[0] . '/' . $file->save_name[1] . '/' . $file->save_name;
        }

        if ( $file->status == 2 ) {
            Yii::$app->session->setFlash('Error', 'Файл в работе');
            return $this->redirect('/order/ready-orders/');
        } elseif ($file->order_id === null && ($session->get('role') == 1)) {
            if ($file->delete()) {
                unlink($path);
                return $this->redirect('/order/show/');
            }
        } elseif ($file->status == 3 && ($session->get('role') == 2)) {
            if ($file->delete()) {
                unlink($path);
                return $this->redirect('/order/ready-orders/');
            }
        }
//        потом, когда раскидаю контроллеры по ролям, переделаю
    }

    public function actionReadyOrders()
    {
        $session = Yii::$app->session;
        $files = Files::find()->where(['status' => 3, 'user_id' => $session->get('id')])->all();
        return $this->render('showReadyOrders', ['files' => $files,]);
    }

    public function actionDownloadReady($id)
    {
        $session = Yii::$app->session;

        $file = Files::find()->where(['id' => $id, 'user_id' => $session->get('id'),])->one();

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

    public function actionTest()
    {
        return $this->render('test');
        echo '<pre>';
        print_r($pdfOrder);
        exit();
    }

}
