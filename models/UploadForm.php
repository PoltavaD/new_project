<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFiles;
use app\models\Files;

class UploadForm extends Model
{
    public $pdfFiles;

    public function rules()
    {
        return [
            [['pdfFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'maxFiles' => 5],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {

            $session = Yii::$app->session;

            foreach ($this->pdfFiles as $file) {
                $save_name = md5(time() . rand(1,99999) . $file->name) . '.' . 'pdf';
                if (!file_exists('./uploads/' . $save_name[0] . '/' . $save_name[1])) {
                    mkdir('./uploads/' . $save_name[0] . '/' . $save_name[1], 0777, true);
                    $file->saveAs('uploads/' . $save_name[0] . '/' . $save_name[1] . '/' . $save_name);
                    if ($file) {
                        $newFile = new Files();
                        $newFile->save_name = $save_name;
                        $newFile->user_id = $session->get('id');
                        $newFile->status = 1;
                        $newFile->pdf_name = $file->name;
                        $newFile->save();
                    }
                }
            }
            return true;

        } else {
            return false;
        }
    }

}