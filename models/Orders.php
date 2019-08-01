<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $pdf_name
 * @property string $save_name
 * @property int $user_id
 * @property int $status
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pdf_name', 'save_name', 'user_id', 'status'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['pdf_name', 'save_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pdf_name' => 'Pdf Name',
            'save_name' => 'Save Name',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }
}
