<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

file name: <input name='pdf_name' value="<?=$Order->pdf_name?>"><br>
<?= $form->field($model, 'pdfOrder')->fileInput
(['accept' => 'pdf']) ?>

    <button class="btn btn-primary" type="submit">Отправить заказчику</button>
<?//= Html::a('Отправить заказчику', ['/order/order-upload'],
//    ['class' => 'btn btn-primary']) ?>
<br>

<br>
<!--<a class="btn btn-primary" href="/order/order-upload" type="submit" role="button">Отправить заказчику</a>-->
<?php ActiveForm::end() ?>
