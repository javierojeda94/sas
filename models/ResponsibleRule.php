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
        return $params['area']->id_responsable == $user->id;
    }
}