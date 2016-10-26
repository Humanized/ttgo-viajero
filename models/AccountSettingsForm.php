<?php

namespace app\models;

use yii\base\Model;
use app\models\User;
use app\models\AccountPasswordForm;
use humanized\localehelpers\Language as LanguageHelper;
use Yii;

/**
 * Signup form
 */
class AccountSettingsForm extends Model
{

    public $token = null;
    public $passwd;
    public $name;
    public $languages = [];
    private $_user;
    private $_password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            [['name', 'country'], 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This user name has already been taken.'],
            ['languages', 'each', 'rule' => ['in', 'range' => LanguageHelper::primary()]],
            ['languages', 'checkLanguages'],
        ];
    }

    public function checkLanguages()
    {
        if (empty($this->languages)) {
            $this->addError('languages', 'At least one spoken language must be provided');
        }
    }

    public function getPasswordSetup()
    {
        return $this->_password;
    }

    public function init()
    {
        parent::init();
        //throw exception if no user logged in
        if (!isset($this->token)) {
            $this->_user = User::findOne(Yii::$app->user->id);
        }
        if (isset($this->token)) {
            $this->_user = User::findByPasswordResetToken($this->token);
            $this->_password = new PasswordSetup(['token' => $this->token]);
        }
        $this->name = $this->_user->username;
        $languageMap = function($userLanguage) {
            return $userLanguage->language;
        };
        $this->languages = array_map($languageMap, $this->_user->languages);
    }

    public function load($data, $formName = null)
    {
        if (isset($this->token) && isset($data['PasswordSetup'])) {
            $this->_password->setAttributes($data['PasswordSetup']);
        }
        return parent::load($data, $formName);
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            return $this->_password->validate();
        }
    }

    public function save()
    {
        if ($this->_password->save()) {
            $this->_user->username = $this->name;
            $this->_user->save();
            $this->_user->syncLanguages($this->languages);
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'languages' => Yii::t('app', 'Languages Spoken'),
            'name' => Yii::t('app', 'Display Name'),
            'country' => Yii::t('app', 'Country of Orgin'),
        ];
    }

}
