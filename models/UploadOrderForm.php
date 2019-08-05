<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Files;

class UploadOrderForm extends Model
{
    /**
     * @var UploadedFile
     */

    public $pdfOrder;

    public function rules()
    {
        return [
            [['pdfOrder'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', ],
        ];
    }

    /**
     * @return bool
     */

    public function upload()
    {
        if ($this->validate()) {

            $session = Yii::$app->session;

            $save_name = md5(time() . rand(1,99999) . $this->pdfOrder->name) . '.' . 'pdf';

            if (!file_exists('./uploads/' . $save_name[0] . '/' . $save_name[1])) {
                mkdir('./uploads/' . $save_name[0] . '/' . $save_name[1], 0777, true);
                $this->pdfOrder->saveAs('uploads/' . $save_name[0] . '/' . $save_name[1] . '/' . $save_name);
                if ($this->pdfOrder) {
                    $newFile = new Files();
                    $newFile->save_name = $save_name;
                    $newFile->user_id = $session->get('id');
                    $newFile->status = 3;
                    $newFile->pdf_name = $this->pdfOrder->name;
                    $newFile->save();
                }
            }

            return true;

        } else {
            return false;
        }
    }

}