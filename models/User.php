<?php

namespace app\models;

use app\models\UserLanguage;

class User extends \humanized\user\models\User
{

    const STATUS_DELETED = -1;
    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 10;

    public function getLanguages()
    {
        return $this->hasMany(UserLanguage::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_PENDING],
            ['status', 'in', 'range' => [self::STATUS_PENDING,self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function syncLanguages($languages)
    {
        $storage = \yii\helpers\ArrayHelper::map($this->languages, 'language', 'language');
        if (is_array($languages)) {
            //Insert all languages from list
            foreach ($languages as $language) {
                if (isset($storage[$language])) {
                    unset($storage[$language]);
                } else {
                    $model = new UserLanguage(['user_id' => $this->id, 'language' => $language]);
                    $model->save();
                }
            }
        }
        foreach ($storage as $toDelete) {
            UserLanguage::deleteAll('user_id=:uid AND language=:lid', ['uid' => $this->id, 'lid' => $toDelete]);
        }
    }

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
