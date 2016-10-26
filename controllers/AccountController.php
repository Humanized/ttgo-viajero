<?php

namespace app\controllers;

use Yii;
use humanized\user\controllers\DefaultController;
use app\models\User;
use humanized\user\models\LoginForm;
use app\models\SignupForm;
use app\models\AccountSettingsForm;

/**
 * SupplyController implements the CRUD actions for Supply model.
 */
class AccountController extends DefaultController
{

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $login = new LoginForm();
        $signup = new SignupForm();
        if ($login->load(Yii::$app->request->post()) && $login->login()) {
            return $this->goBack();
        }
        if ($signup->load(Yii::$app->request->post())) {

            if (NULL !== $signup->save()) {
                Yii::$app->session->setFlash('info', Yii::t('app', 'account-signup-success'));
            }
        }
        return $this->render('index', [
                    'login' => $login,
                    'signup' => $signup,
        ]);
    }

    public function actionSettings()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goBack();
        }
        $model = new AccountSettingsForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'Changes Saved');
        }
        return $this->render('settings', ['model' => $model]);
    }

    public function actionConfirm($token)
    {
        if (!User::isPasswordResetTokenValid($token)) {
            Yii::$app->session->setFlash('error', 'Confirmation link expired - Use password reset to regenerate link');
            return $this->redirect(['request-password-reset']);
        }

        $model = new AccountSettingsForm(['token' => $token]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect('index');
            
            return;
        }
        return $this->render('settings', ['model' => $model]);
    }

}
