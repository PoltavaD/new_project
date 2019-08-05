<?php
$this->title = 'new_project';
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<table class="table table-striped">
    <tr><th>Order_id</th>
        <th>Name</th>
        <th>Status</th>
        <th>Скачать</th>
        <th>Выполнить</th>
    </tr>
    <?foreach ($files as $file) { ?>
        <tr>
            <td><?=$file->id?></td>
            <td><?=$file->pdf_name?></td>
            <td><?=$file->status?></td>
            <td>
                <?= Html::a('Скачать', ['/order/download', 'id' => $file->id],
                    ['class' => 'btn btn-primary']) ?></td>
            <td><?= Html::a('Выполнить', ['/order/send-order', 'id' => $file->id],
                    ['class' => 'btn btn-primary']) ?></td>
        </tr>
    <?}?>
</table>
