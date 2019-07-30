<?php
$this->title = 'new_project';
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-lg-5">

        <?php $form = ActiveForm::begin(['id' => 'RegForm']); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'pass')->passwordInput() ?>

        <?= $form->field($model, 'role')->radioList([1 =>'customer', 2 => 'lawyer'])->label('Вы кто?') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary',
                'name' => 'reg-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>


