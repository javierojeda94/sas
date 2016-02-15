<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property string $id
 * @property string $category_id
 * @property string $id_area
 * @property string $name
 * @property string $description
 * @property integer $service_level_agreement_asignment
 * @property integer $service_level_agreement_completion
 *
 * @property Category $category
 * @property Category[] $categories
 * @property Area $idArea
 * @property CategoryRequest[] $categoryRequests
 * @property Request[] $requests
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'id_area', 'service_level_agreement_asignment', 'service_level_agreement_completion'], 'integer'],
            [['id_area', 'name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Father Category'),
            'id_area' => Yii::t('app', 'Area'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'service_level_agreement_asignment' => Yii::t('app', 'Service Level Agreement Asignment'),
            'service_level_agreement_completion' => Yii::t('app', 'Service Level Agreement Completion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryRequests()
    {
        return $this->hasMany(CategoryRequest::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['id' => 'request_id'])->viaTable('category_request', ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }
}
