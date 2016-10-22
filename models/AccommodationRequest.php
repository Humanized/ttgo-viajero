<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accommodation_request".
 *
 * @property integer $id
 * @property integer $accommodation_id
 * @property integer $request_id
 * @property integer $request_count
 * @property integer $is_accepted
 *
 * @property Accommodation $accommodation
 * @property Request $request
 */
class AccommodationRequest extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accommodation_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accommodation_id', 'request_id', 'request_count'], 'required'],
            [['accommodation_id', 'request_id', 'request_count', 'is_accepted'], 'integer'],
            ['is_accepted', 'default', 'value' => 0],
            [['accommodation_id'], 'exist', 'skipOnError' => false, 'targetClass' => Accommodation::className(), 'targetAttribute' => ['accommodation_id' => 'id']],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'accommodation_id' => Yii::t('app', 'Accommodation ID'),
            'request_id' => Yii::t('app', 'Request ID'),
            'request_count' => Yii::t('app', 'Request Count'),
            'is_accepted' => Yii::t('app', 'Accept'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccommodation()
    {
        return $this->hasOne(Accommodation::className(), ['id' => 'accommodation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->request_count > 0) {
            return true;
        }
        if (!$insert) {
            $this->delete();
        }
        return false;
    }

}
