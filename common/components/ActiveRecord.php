<?php

namespace common\components;

use Yii;
use common\models\UserActivity;

class ActiveRecord extends \yii\db\ActiveRecord
{

    const SCENARIO_IMPORT = 'import';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_IMPORT] = $scenarios[self::SCENARIO_DEFAULT];        
        return $scenarios;
    }

    public function delete()
    {
        if($this->hasAttribute('is_deleted')) {

            if (!$this->beforeDelete()) return false;

            $result = $this->updateAttributes(['is_deleted' => 1]);

            $this->afterDelete();

            return $result;

        } else {
            return parent::delete();
        }
    }

    public function restore()
    {
        if ($this->hasAttribute('is_deleted')) {

            $result = $this->updateAttributes(['is_deleted' => 0]);

            $this->afterRestore();

            return $result;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::class, [get_called_class()]);
    }

    public function afterRestore()
    {
        if ($this->scenario === self::SCENARIO_DEFAULT) {
            static::log('restore', $this);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if ($this->scenario === self::SCENARIO_DEFAULT) {
            static::log('delete', $this);
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->scenario === self::SCENARIO_DEFAULT) {
            static::log($insert ? 'create' : 'update', $this);
        }
    }

    public static function log($verb, ActiveRecord $model, $obj_id = null)
    {
        $obj = explode('\\', get_class($model));
        $obj = end($obj);

        if(in_array($obj, self::ignoreModelsOnLog())) return null;

        isset($model->company_id)
            ? $company_id = $model->company_id
            : $company_id = null;

        $log = new UserActivity([
            'user_id' => Yii::$app->user->id,
            'company_id' => $company_id,
            'verb' => $verb,
            'obj' => $obj,
            'obj_id' => $obj_id ? $obj_id : $model->id,
        ]);
        $log->save(false);
    }

    private static function ignoreModelsOnLog()
    {
        return [
            'EquipmentMonitorLimit',
            'ProfileForm',
            'ChangePasswordForm',
            'LicenseKey',
        ];
    }


    public static function findOne($condition)
    {
        if(Yii::$app->id !== 'app-frontend') {
            return parent::findOne($condition);
        }

        $ignoreModels = ['common\models\CompanyType', 'common\models\CompanyDistrict', 'common\models\User', 'frontend\models\Company'];

        if(in_array(get_called_class(), $ignoreModels)) {
            return parent::findOne($condition);
        }

        if(Yii::$app->company->id) {

            if(get_called_class() === 'common\models\VehicleSpeedLimit') {
                if(isset($condition['id'])) {
                    $condition['t.id'] = $condition['id'];
                    unset($condition['id']);
                }
                return static::find()->alias('t')->joinWith('model')->andCompanyDescendantScope(Yii::$app->company->id, 'vehicle_model')->andWhere($condition)->one();
            }

            if(get_called_class() === 'frontend\models\EquipmentFirmware') {
                if(isset($condition['id'])) {
                    $condition['t.id'] = $condition['id'];
                    unset($condition['id']);
                }
                return static::find()->alias('t')->joinWith('model')->andCompanyDescendantScope(Yii::$app->company->id, 'equipment_model')->andWhere($condition)->one();
            }

            return static::find()->andCompanyDescendantScope(Yii::$app->company->id)->andWhere($condition)->one();
        }

        return parent::findOne($condition);
    }


}
