<?php

namespace backend\models;

use Yii;

class RecordHelpers
{
    const OWNER = 1;

    public static function userIsOwner($model_id)
    {
        $conexion = \Yii::$app->db;
        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM project LEFT JOIN project_user 
                ON project_user.project_id = project.id WHERE user_id=:userid AND project_id=:model_id 
                AND role_id = " . self::OWNER;
        $comando = $conexion->createCommand($sql);
        $comando->bindValue(":userid", $userid);
        $comando->bindValue(":model_id", $model_id);
        if ($result = $comando->queryOne()) {
            return true;
        } else {
            return false;
        }
    }
}
