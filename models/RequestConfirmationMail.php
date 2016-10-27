<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class RequestConfirmationMail extends Model
{

    const INCOMING = 'in';
    const OUTGOING = 'out';

    public $mode;

    /**
     *
     * @var Request 
     */
    public $request;

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function send()
    {
        $subject = Yii::t('mail', 'request_' . $this->mode . '_subject');

        return Yii::$app->mailer
                        ->compose(
                                ['html' => 'confirmRequest-html', 'text' => 'confirmRequest-text'], ['request' => $this->request, 'mode' => $this->mode]
                        )
                        ->setFrom([Yii::$app->params['autoEmail'] => Yii::$app->name])
                        ->setTo($this->mode == self::INCOMING ? $this->request->recipient->email : $this->request->sender->email)
                        ->setSubject($subject)
                        ->send();
    }

}
