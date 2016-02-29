<?php
/**
 * Created by PhpStorm.
 * User: javier
 * Date: 28/02/16
 * Time: 10:57 PM
 */

namespace app\models;
use yii\rbac\Rule;


class AssignedRule extends Rule{

    public $name = "isAssigned";

    public function execute($user, $item, $params)
    {
        $assigned = UsersRequest::find()
            ->where([
                'request_id'=>$params['request']->id,
                'user_id'=>$user->id // marca un error aqui diciendo que el objeto $user es nulo
            ])->one();
        return $assigned;
    }
}