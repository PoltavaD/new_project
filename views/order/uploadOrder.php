<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\UploadOrderForm */
/* @var $Order \app\models\Orders|array|null|\yii\db\ActiveRecord */

use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <input name='order_id' type="hidden" value="<?=Yii::$app->request->get('id')?>"><br>

    file name: <input name='pdf_name' value="<?=Yii::$app->request->get('pdf_name')?>"><br>

<?= $form->field($model, 'pdfOrder')->fileInput
(['accept' => 'pdf']) ?>

    <button class="btn btn-primary" type="submit">Отправить заказчику</button>

<?php ActiveForm::end() ?>
<?
//echo '<pre>';
//print_r(Yii::$app->request->get());
//echo '</pre>';
//exit();