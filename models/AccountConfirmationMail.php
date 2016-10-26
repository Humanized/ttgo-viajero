<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class AccountConfirmationMail extends Model
{

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_PENDING],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function send()
    {
        $userClass = \Yii::$app->user->identityClass;
        /* @var $user User */
        $user = $userClass::findOne([
                    'status' => User::STATUS_PENDING,
                    'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!$userClass::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $subject = Yii::t('mail', 'confirmation_subject');

        return Yii::$app->mailer
                        ->compose(
                                ['html' => 'confirmAccount-html', 'text' => 'confirmAccount-text'], ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['autoEmail'] => Yii::$app->name])
                        ->setTo($this->email)
                        ->setSubject($subject)
                        ->send();
    }

}
