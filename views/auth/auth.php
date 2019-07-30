<?php
$this->title = 'new_project';
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="site-login">
    <div class="col-lg-4">

        <?php $form = ActiveForm::begin(['id' => 'LogForm']); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'pass')->passwordInput()  ?>

        <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary',
                    'name' => 'login-button']) ?>
        </div>

        <div class="form-group">

            <?= Html::a('Зарегестрироваться', ['/auth/registration'], ['class' => 'btn btn-primary',
                'name' => 'reg-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <a class="btn btn-primary" href="auth/logout/" role="button">Logout</a>

    </div>
</div>

