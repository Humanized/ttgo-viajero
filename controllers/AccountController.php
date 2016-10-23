<?php

namespace app\controllers;

use Yii;
use humanized\user\controllers\DefaultController as ParentController;
use humanized\user\models\LoginForm;
use app\models\SignupForm;

/**
 * SupplyController implements the CRUD actions for Supply model.
 */
class AccountController extends ParentController
{

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $login = new LoginForm();
        $signup = new \app\models\SignupForm;
        if ($login->load(Yii::$app->request->post()) && $login->login()) {
            return $this->goBack();
        }

        if ($signup->load(Yii::$app->request->post())) {

            if (NULL !== $signup->save()) {
                return $this->render('confirmation', [
                ]);
            }
        }

        return $this->render('index', [
                    'login' => $login,
                    'signup' => $signup,
        ]);
    }

}
