<?php

namespace app\models;

use yii\base\Model;
use humanized\usermanagement\common\models\UserCrud;

/**
 * Signup form
 */
class RegistrationForm extends Model
{

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        
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

        return $user;
    }

}
