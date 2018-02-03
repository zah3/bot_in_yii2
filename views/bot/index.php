<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
//session_destroy();
$session = Yii::$app->session;
if(!$session->isActive)
    $session->open();

$answer = new \app\models\Answer();
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php Pjax::begin() ?>
                <?php if(isset($_SESSION['conversation'])):?>
                    <?php foreach($_SESSION['conversation'] as $conversation) :?>
                        <?= 'author: ' . $conversation['author'] .' value: ' . $conversation['value']  ?> <br>
                    <?php endforeach;?>
                <?php endif; ?>
                <?= Html::beginForm(['/bot'],'post',['data-pjax' => '']) ?>
                    <?= Html::textarea('value',null, ['class' => 'form-control','id' => 'value'])?>
                    <?= Html::submitInput('send',['class' => 'btn btn-info', 'id' => 'send'])?>
                <?= Html::endForm() ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>