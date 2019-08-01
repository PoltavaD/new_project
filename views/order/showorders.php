<?php
$this->title = 'new_project';
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Files;

/* @var $this \yii\web\View */
/* @var $files \app\models\Files[]|array|\yii\db\ActiveRecord[] */
?>

<!--<div>-->
<!--    --><?// echo $role?>
<!--</div>-->
<!--<br>-->
<!--<br>-->
<table class="table table-striped">
    <tr><th>Order_id</th>
        <th>Name</th>
        <th>Status</th>
    <?foreach ($files as $file) { ?>
        <tr><td><?=$file->order_id?></td>
        <td><?=$file->pdf_name?></td>
        <td><?=$file->status?></td>
    <?}?>
</table>
<div>
    <?= Html::a('Разместить заказ', ['/order/upload'], ['class' => 'btn btn-primary',
        'name' => 'reg-button']) ?>
</div>