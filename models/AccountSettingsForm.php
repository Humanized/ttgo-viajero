<?php

namespace app\models;

use yii\base\Model;
use app\models\User;
use app\models\UserLanguage;
use humanized\localehelpers\Language as LanguageHelper;
use Yii;

/**
 * Signup form
 */
class AccountSettingsForm extends Model
{

    public $passwordResetToken = null;
    public $name;
    public $languages = [];
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
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

    public function init()
    {
        parent::init();
        //throw exception if no user logged in
        $this->_user = User::findOne(Yii::$app->user->id);
        $this->name = $this->_user->username;
        $languageMap = function($userLanguage) {
            return $userLanguage->language;
        };
        $this->languages = array_map($languageMap, $this->_user->languages);
    }

    public function save()
    {
        $this->_user->username = $this->name;
        $this->_user->status = User::STATUS_ACTIVE;
        $this->_user->save();
        $this->_user->syncLanguages($this->languages);
        return true;
    }

}
