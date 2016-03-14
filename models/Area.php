<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property string $id
 * @property string $area_id
 * @property string $id_responsable
 * @property string $name
 * @property string $description
 *
 * @property AreaPersonal[] $areaPersonals
 * @property User[] $users
 * @property Area $area
 * @property Area[] $areas
 * @property User $idResponsable
 * @property AreasRequest[] $areasRequests
 * @property Request[] $requests
 * @property Category[] $categories
 * @property Request[] $requests0
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'id_responsable'], 'integer'],
            [['name','id_responsable','description'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 150],
            [['id_responsable'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'area_id' => Yii::t('app', 'Father Area'),
            'id_responsable' => Yii::t('app', 'Responsable'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaPersonals()
    {
        return $this->hasMany(AreaPersonal::className(), ['area_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('area_personal', ['area_id' => 'id']);
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
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['area_id' => 'id']);
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)) {
            $auth = Yii::$app->authManager;
            $jefeArea = $auth->getRole('responsibleArea');
            $roles = $auth->getRolesByUser($this->id_responsable);
            $isResponsibleOfArea = false;
            foreach($roles as $role){
                if($role == $jefeArea){
                    $isResponsibleOfArea = true;
                }
            }
            if(!$isResponsibleOfArea){
                $auth->assign($jefeArea, $this->id_responsable);
                return true;
            }
        }
        return false;
    }
    public function beforeDelete(){
        if(parent::beforeDelete()) {
            $auth = Yii::$app->authManager;
            $jefeArea = $auth->getRole('responsibleArea');
            $auth->revoke($jefeArea, $this->id_responsable);

            foreach($this->areaPersonals as $personal){
                $personal->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdResponsable()
    {
        return $this->hasOne(User::className(), ['id' => 'id_responsable']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreasRequests()
    {
        return $this->hasMany(AreasRequest::className(), ['area_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['id' => 'request_id'])->viaTable('areas_request', ['area_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id_area' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests0()
    {
        return $this->hasMany(Request::className(), ['area_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AreasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AreasQuery(get_called_class());
    }
}
