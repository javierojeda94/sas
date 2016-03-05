<?php
/**
 * Created by PhpStorm.
 * User: javier
 * Date: 28/02/16
 * Time: 10:57 PM
 */

namespace app\models;
use yii\rbac\Rule;


class ResponsibleRule extends Rule{

    public $name = "isResponsible";

    public function execute($user, $item, $params)
    {
        $area = Area::find()->where(['id_responsable' => \Yii::$app->user->id])->one();
        return isset($area);
    }
}