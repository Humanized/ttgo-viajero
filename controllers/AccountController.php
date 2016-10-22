<?php

namespace app\controllers;

use Yii;
use humanized\user\controllers\DefaultController as ParentController;
use humanized\user\models\LoginForm;
use humanized\user\models\SignupForm;

/**
 * SupplyController implements the CRUD actions for Supply model.
 */
class AccountController extends ParentController
{

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $login = new LoginForm();
        $signup = new SignupForm();
        if ($login->load(Yii::$app->request->post()) && $login->login()) {
            return $this->goBack();
        }

        return $this->render('index', [
                    'login' => $login,
                    'signup' => $signup,
        ]);
    }

}
