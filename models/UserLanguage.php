<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_language".
 *
 * @property integer $user_id
 * @property string $language
 */
class UserLanguage extends \yii\db\ActiveRecord
{

    public $touched = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'language'], 'required'],
            [['user_id'], 'integer'],
            [['language'], 'string', 'max' => 2],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    public static function available()
    {
       
    }

}
