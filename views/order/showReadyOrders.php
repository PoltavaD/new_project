<?php

/**
 * Created by PhpStorm.
 * User: Poltava
 * Date: 06.08.2019
 * Time: 4:52
 */

/* @var $this \yii\web\View */
/* @var $files \app\models\Files[]|\app\models\Orders[]|array|\yii\db\ActiveRecord[] */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<table class="table table-striped">
    <tr><th>Order_id</th>
        <th>Name</th>
        <th>Status</th>
        <th>Скачать</th>
        <th>Удалить</th>
    </tr>
    <?foreach ($files as $file) { ?>
        <tr>
            <td><?=$file->order_id?></td>
            <td><?=$file->pdf_name?></td>
            <td><?=$file->status?></td>
            <td><?= Html::a('Скачать', ['/order/download-ready', 'id' => $file->id],
                    ['class' => 'btn btn-primary']) ?></td>
            <td><?= Html::a('Удалить', ['/order/delete', 'id' => $file->id],
                    ['class' => 'btn btn-danger']) ?></td>
        </tr>
    <?}?>
</table>
