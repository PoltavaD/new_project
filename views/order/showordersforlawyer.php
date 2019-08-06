<?php

/**
 * Created by PhpStorm.
 * User: Poltava
 * Date: 29.07.2019
 * Time: 19:48
 */

/* @var $this \yii\web\View */
/* @var $files \app\models\Files[]|array|\yii\db\ActiveRecord[] */
$this->title = 'new_project';
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<table class="table table-striped">
    <tr><th>Order_id</th>
        <th>Name</th>
        <th>Status</th>
        <th>Взять в работу</th>
    </tr>
    <?foreach ($files as $file) { ?>
    <tr>
        <td><?=$file->order_id?></td>
        <td><?=$file->pdf_name?></td>
        <td><?=$file->status?></td>
        <td><?= Html::a('Взять в работу', ['/order/take-work', 'id' => $file->id],
                ['class' => 'btn btn-primary']) ?></td>
    </tr>
    <?}?>
</table>

<?= Html::a('Приступить к работе', ['/order/work'],
    ['class' => 'btn btn-primary']) ?>

