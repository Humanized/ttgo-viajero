<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $is_new
 * @property string $request_date
 * @property string $request_message
 * @property string $response_date
 * @property string $response_message
 */
class Request extends \yii\db\ActiveRecord
{

    public $supplyId;
    public $accommodation = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'is_new', 'supplyId'], 'integer'],
            [['supplyId', 'request_date', 'request_message'], 'required'],
            [['request_date', 'response_date'], 'safe'],
            ['is_new', 'default', 'value' => 1],
            [['request_message', 'response_message'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'From'),
            'is_new' => Yii::t('app', 'Is New'),
            'request_date' => Yii::t('app', 'Date'),
            'request_message' => Yii::t('app', 'Request Message'),
            'response_date' => Yii::t('app', 'Response Date'),
            'response_message' => Yii::t('app', 'Response Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccommodationRequests()
    {
        return $this->hasMany(AccommodationRequest::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccommodationRequest()
    {
        return $this->hasOne(AccommodationRequest::className(), ['request_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplyAccommodation()
    {
        return $this->hasOne(Accommodation::className(), ['id' => 'accommodation_id'])->via('accommodationRequest');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupply()
    {
        return $this->hasOne(Supply::className(), ['id' => 'supply_id'])->via('supplyAccommodation');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->via('supply');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function isRejected()
    {
        if ($this->response_date === null) {

            return false;
        }

        foreach ($this->accommodationRequests as $accommodationRequest) {
            if ($accommodationRequest->is_accepted) {
                return false;
            }
        }
        return true;
    }

    public function init()
    {
        parent::init();
        $this->accommodation = [];

        $currentDate = Yii::$app->params['dateStart'];
        while ($currentDate != Yii::$app->params['dateStop'] + 1) {
            $this->accommodation[$currentDate] = new AccommodationRequest(['is_accepted' => 0, 'request_count' => 0]);
            $currentDate++;
        }
    }

    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {

            foreach ($data['AccommodationRequest'] as $key => $value) {

                //Get accommodation supplied for key
                $accommodation = Supply::findAccommodation($this->supplyId, $key);
                if (isset($accommodation)) {
                    $model = $this->accommodation[$key];
                    $model->accommodation_id = $accommodation->id;
                    $model->request_count = $value["request_count"];
                }
            }
            return true;
        }
        return false;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (!isset($this->request_date)) {
                $this->request_date = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) {
            $this->respond_date = date('Y-m-d H:i:s');
        }
        foreach ($this->accommodation as $accommodation) {
            $accommodation->request_id = $this->id;
            $accommodation->save();
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        $this->supplyId = $this->accommodationRequests[0]->accommodation->supply_id;

        foreach ($this->accommodationRequests as $accommodationRequest) {
            $this->accommodation[date("Ymd", strtotime($accommodationRequest->accommodation->accommodation_date))] = $accommodationRequest;
        }

        return parent::afterFind();
    }

}
