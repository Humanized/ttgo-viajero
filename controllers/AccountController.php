<?php

namespace app\controllers;

use Yii;
use humanized\user\controllers\DefaultController;
use app\models\User;
use app\models\AccountLogin;
use app\models\AccountRegister;
use app\models\AccountSettings;
use app\models\AccountResetRequest;
use app\models\PasswordSetup;

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

        $login = new AccountLogin();
        $signup = new AccountRegister();
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
        $model = new AccountSettings();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'Changes Saved');
        }
        return $this->render('settings', ['model' => $model]);
    }

    public function actionConfirm($token)
    {
        if (!User::isPasswordResetTokenValid($token)) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'link.error{type}{status}', ['type' => 'Confirmation', 'status' => 'expired']));
            return $this->redirect(['request-account-reset']);
        }

        if (NULL === User::findByPasswordResetToken($token)) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'link.error{type}{status}', ['type' => 'Confirmation', 'status' => 'invalid']));
            return $this->redirect(['request-account-reset']);
        }

        $model = new AccountSettings(['token' => $token]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'account-confirm-success'));
            $this->redirect('index');

            return;
        }
        return $this->render('settings', ['model' => $model]);
    }

    public function actionRequestAccountReset()
    {
        $model = new AccountResetRequest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', Yii::t('app', 'account-reset-send'));
            return $this->redirect('index');
        }

        return $this->render('request-reset', ['model' => $model]);
    }

    public function actionResetPassword($token)
    {
        if (!User::isPasswordResetTokenValid($token)) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'link.error{type}{status}', ['type' => 'Reset', 'status' => 'expired']));
            return $this->redirect(['request-account-reset']);
        }

        if (NULL === User::findByPasswordResetToken($token)) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'link.error{type}{status}', ['type' => 'Reset', 'status' => 'invalid']));
            return $this->redirect(['request-account-reset']);
        }

        $model = new PasswordSetup(['token' => $token]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', Yii::t('app', 'account-reset-success'));
            return $this->redirect('index');
        }
        return $this->render('reset-password', ['model' => $model]);
    }

}
