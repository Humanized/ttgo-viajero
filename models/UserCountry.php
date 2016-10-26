<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_country".
 *
 * @property integer $user_id
 * @property string $country
 */
class UserCountry extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'country'], 'required'],
            [['user_id'], 'integer'],
            [['country'], 'string', 'max' => 2],
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
            'country' => Yii::t('app', 'Country'),
        ];
    }

}
