<?php

namespace app\models;

class User extends \humanized\user\models\User
{

    const STATUS_DELETED = -1;
    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 10;

    /*
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
     * 
     */
}
