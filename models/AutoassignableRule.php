<?php
/**
 * Created by PhpStorm.
 * User: javier
 * Date: 28/02/16
 * Time: 10:57 PM
 */

namespace app\models;
use yii\rbac\Rule;


class AutoassignableRule extends Rule{

    public $name = "isAutoassignable";

    public function execute($user, $item, $params)
    {
        //TODO determinar si el usuario tiene permisos para auto-asignarse solicitudes
        return true;
    }
}