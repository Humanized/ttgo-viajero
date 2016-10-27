<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accommodation".
 *
 * @property integer $id
 * @property integer $supply_id
 * @property string $accommodation_date
 * @property integer $accommodation_count
 */
class Accommodation extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accommodation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supply_id', 'accommodation_count'], 'integer'],
            [['accommodation_date', 'accommodation_count'], 'required'],
            [['accommodation_date'], 'safe'],
            [['supply_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supply::className(), 'targetAttribute' => ['supply_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'supply_id' => Yii::t('app', 'Supply ID'),
            'accommodation_date' => Yii::t('app', 'Accommodation Date'),
            'accommodation_count' => Yii::t('app', 'Accommodation Count'),
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->accommodation_count > 0) {
            return true;
        }
        if (!$insert) {
            $this->delete();
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccommodationRequests()
    {
        return $this->hasMany(AccommodationRequest::className(), ['accommodation_id' => 'id']);
    }

    public function getReserved()
    {
        $count = 0;
        foreach ($this->accommodationRequests as $request) {
            if ($request->is_accepted) {
                $count += $request->request_count;
            }
        }
        return $count;
    }

    public function getAvailable()
    {
        return $this->accommodation_count - $this->reserved;
    }

}
