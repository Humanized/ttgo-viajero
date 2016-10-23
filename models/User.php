<?php

namespace app\models;

class User extends \humanized\user\models\User
{

    public $languageList = [];

    public function getLanguages()
    {
        return $this->hasMany(UserLanguage::className(), ['user_id' => 'id']);
    }

    public function afterFind()
    {
        $this->languageList = array_map(function($model) {
            return $model->language;
        }, $this->languages);
        return parent::afterFind();
    }

    public function afterSave($insert, $changedAttributes)
    {
        UserLanguage::sync($this->id, $this->languageList);
        return parent::afterSave($insert, $changedAttributes);
    }

}
