<?php

/*
 * Startup operations, keep fast!
 * @link http://www.yiiframework.com/doc-2.0/guide-runtime-bootstrapping.html
 */

namespace app\components;

class SiteTitle extends \yii\base\Component
{

    public function init()
    {
        \Yii::$app->view->on(\yii\web\View::EVENT_AFTER_RENDER, function ($event) {
            if (!strpos(\yii::$app->view->title, \Yii::$app->name)) {
                \yii::$app->view->title .= " - " . \Yii::$app->name;
            }
        });
    }

}
