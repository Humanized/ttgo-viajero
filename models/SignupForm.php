<?php

namespace app\models;

use yii\base\Model;
use humanized\usermanagement\common\models\UserCrud;
use humanized\user\models\AccountConfirmation;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = UserCrud::create(['email' => $this->email]);
        if (isset($user)) {
            (new AccountConfirmation(['email' => $user->email]))->sendEmail();
        }
        return $user;
    }

}
