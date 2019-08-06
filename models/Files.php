<?php

namespace app\models;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property int $status
 * @property string $pdf_name
 * @property string $save_name
 *
 * @property Users $user
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */

    const STATUS_ZAYAVKA = 1;
    const STATUS_INWORK = 2;

//    public function getStatusText()
//    {
//        return ($this->status);
//    }
//
//    public function setStatusText($value)
//    {
//        if ($value == 1) {
//            $this->status = 'Заявка оставлена';
//        }
//
//        if ($value == 2) {
//            $this->status = 'В работе';
//        }
//
//        if ($value == 3) {
//            $this->status = 'Готово';
//        }
//    }

//    Почему не работает функция выше? Или как по другому сделать замену цифрового статуса на текст?

    public function rules()
    {
        return [
            [['user_id', 'pdf_name', 'save_name'], 'required'],
            [['user_id', 'order_id', 'status'], 'integer'],
            [['pdf_name', 'save_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(),
                'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'status' => 'Status',
            'pdf_name' => 'Pdf Name',
            'save_name' => 'Save Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
