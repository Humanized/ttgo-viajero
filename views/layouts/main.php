<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta property="og:title" content="ACCOMODATION &amp; HOSTING"/>
        <meta property="og:type" content="article"/>
        <meta property="og:url" content="https://ttipgameover.net/en/ttip-game-over-round-2-accomodation/"/>
        <meta property="og:site_name" content="TTIP GAME OVER"/>
        <meta property="og:description" content="In order to receive the TTIP Game Over newsletter, send an e-mail to this address, with &quot;Subscription newsletter TTIP Game Over&quot; in the subject line :news.ttipgameover  riseup.net

              For all TTIP Game Over-related questions :

              ttipgameover  riseup.net

              For all questions related to international mobilisation:

              ttipgameover_intl  riseup.net

              If you have some questions about"/>
              <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <div class="container">
                <div class="pull-right">

                    <?=
                    Yii::$app->user->isGuest ? Html::a('<i style="font-weight:bold;" class="glyphicon glyphicon-log-in"></i>', ['account/index'], ['class' => 'btn btn-info']) :
                            Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                    '<i style="font-weight:bold;" class="glyphicon glyphicon-log-out"></i>', ['class' => 'btn btn-danger logout']
                            )
                            . Html::endForm();
                    ?>
                </div>
                <div class="jumbotron">
                    <h2>TTIP Game Over: Round #2<span><?= Yii::t('app', 'Hosting &amp; Accommodation'); ?></span></h2>

                    <p class="lead">Write a little intro about hosting here</p>
                    <p>
                        <?= Html::a(Yii::t('app', 'Offer Hosting'), ['host/offer'], ['class' => "btn btn-lg btn-success"]); ?> 
                        <?= Html::a(Yii::t('app', 'Find Hosting'), ['host/find'], ['class' => "btn btn-lg btn-success"]); ?>
                        <?= Yii::$app->user->isGuest ? '' : Html::a('Requests', ['request/index'], ['class' => "btn btn-lg btn-info"]); ?>
                    </p>
                </div>

                <?= $content ?>
            </div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
