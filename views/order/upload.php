<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'pdfFiles[]')->fileInput
(['multiple' => true, 'accept' => 'pdf']) ?>

<button class="btn btn-primary" type="submit">Загрузить</button>

<?php ActiveForm::end() ?>
