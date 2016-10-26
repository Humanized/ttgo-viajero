<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Signup form
 */
class PasswordSetup extends Model
{

    public $token = null;
    public $password;
    public $password_repeat;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 8],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }

    public function init()
    {
        parent::init();
        if (isset($this->token)) {
            $this->_user = User::findByPasswordResetToken($this->token);
        }
    }

    public function save()
    {

        $this->_user->setPassword($this->password);
        $this->_user->status = User::STATUS_ACTIVE;
        $this->_user->removePasswordResetToken();
        return $this->_user->save();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Confirm Password'),
        ];
    }

}
