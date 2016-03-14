<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area_personal".
 *
 * @property integer $area_id
 * @property integer $user_id
 * @property integer $permission
 *
 * @property Area $area
 * @property User $user
 */
class AreaPersonal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area_personal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'user_id', 'permission'], 'required'],
            [['area_id', 'user_id', 'permission'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => 'Area ID',
            'user_id' => 'User ID',
            'permission' => 'Permission',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //Aqui se agregan los permisos al usuario
            $auth = Yii::$app->authManager;
            $employeeArea = $auth->getRole('employeeArea');
            $roles = $auth->getRolesByUser($this->user_id);
            $isEmployee = false;
            foreach($roles as $role){
                if($role == $employeeArea){
                    $isEmployee = true;
                }
            }
            if(!$isEmployee){
                $auth->assign($employeeArea, $this->user_id);
                return true;
            }
        }
        return false;
    }
    public function beforeDelete(){
        if(parent::beforeDelete()) {
            $auth = Yii::$app->authManager;
            $employee = $auth->getRole('employeeArea');
            $auth->revoke($employee, $this->user_id);
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
