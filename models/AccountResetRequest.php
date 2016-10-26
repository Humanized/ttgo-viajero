<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Password reset request form
 */
class AccountResetRequest extends Model
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
                'filter' => ['IN', 'status', [User::STATUS_ACTIVE, User::STATUS_PENDING]],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    public function save()
    {
        $user = User::findOne(['email' => $this->email]);
        if (isset($user)) {
            $class = '\\app\\models\\' . ($user->status == User::STATUS_PENDING ? 'AccountConfirmationMail' : 'AccountResetMail');
            $email = new $class(['email' => $user->email]);
            return $email->send();
            
        }
        return false;
    }

}
