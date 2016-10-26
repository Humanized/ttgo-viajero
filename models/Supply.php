<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supply".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $description_public
 * @property string $description_private
 * @property integer $has_wifi
 * @property integer $has_kitchen
 * @property integer $has_shower
 */
class Supply extends \yii\db\ActiveRecord
{

    public $accommodation = [];

    public function init()
    {
        parent::init();
        $this->accommodation = [];

        $currentDate = Yii::$app->params['dateStart'];
        while ($currentDate != Yii::$app->params['dateStop'] + 1) {
            $this->accommodation[$currentDate] = new Accommodation(['accommodation_date' => date("Y-m-d", strtotime($currentDate)), 'accommodation_count' => 0]);
            $currentDate++;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'has_wifi', 'has_kitchen', 'has_shower'], 'integer'],
            [['description_public', 'description_private'], 'string'],
            [['description_public'], 'required'],
            ['accommodation', 'checkAccommodation'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function checkAccommodation()
    {
        $hasAccommodation = false;
        foreach ($this->accommodation as $model) {
            if (!(is_numeric($model->accommodation_count) && $model->accommodation_count >= 0)) {
                $this->addError('accommodation', 'A positive, numeric value is required');
                break;
            }
            if (!$hasAccommodation && $model->accommodation_count > 0) {
                $hasAccommodation = true;
            }
        }
        if (!$hasAccommodation) {
            $this->addError('accommodation', 'No Accommodations specified');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'description_public' => Yii::t('app', 'Public Description'),
            'description_private' => Yii::t('app', 'Private Description'),
            'has_wifi' => Yii::t('app', 'Wifi'),
            'has_kitchen' => Yii::t('app', 'Kitchen'),
            'has_shower' => Yii::t('app', 'Shower'),
        ];
    }

    public function beforeValidate()
    {

        if (parent::beforeValidate()) {
            if ($this->scenario == self::SCENARIO_DEFAULT) {
                $this->user_id = \Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {

        foreach ($this->accommodation as $accommodation) {
            $accommodation->supply_id = $this->id;
            $accommodation->save();
            \yii\helpers\VarDumper::dump($accommodation->errors);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        foreach ($this->accommodations as $accommodation) {
            $this->accommodation[date("Ymd", strtotime($accommodation->accommodation_date))] = $accommodation;
        }

        return parent::afterFind();
    }

    public function load($data, $formName = null)
    {
        if (parent::load($data, $formName)) {
            //  var_dump($data['Accommodation']);
            foreach ($data['Accommodation'] as $key => $value) {
                $model = $this->accommodation[$key];
                $model->accommodation_count = $value["accommodation_count"];
            }
            //   $this->accommodation = $data['Accommodation'];
            return true;
        }
        return false;
    }

    public function getAccommodations()
    {
        return $this->hasMany(Accommodation::className(), ['supply_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function findAccommodation($id, $date)
    {
        $model = self::findOne($id);
        if (isset($model) && $model->accommodation[$date]->accommodation_count > 0) {
            return $model->accommodation[$date];
        }
        return null;
    }

}
