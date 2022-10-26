<?php

namespace backend\models;

use Yii;
 


use backend\traits\EnforceProjectContextTrait;
use yii\helpers\ArrayHelper;

use common\models\User; 

/**
 * This is the model class for table "project_user".
 *
 * @property int $project_id
 * @property int $user_id
 * @property int $role_id
 *
 * @property Project $project
 * @property Role $role
 * @property User $user
 */
class ProjectUser extends \yii\db\ActiveRecord
{
    use EnforceProjectContextTrait;
    /**
     * {@inheritdoc}
     */
    public $userEmail; 

    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * {@inheritdoc}
     */
    /* public function rules()
    {
        return [
            [['project_id', 'user_id', 'role_id'], 'required'],
            [['project_id', 'user_id', 'role_id'], 'integer'],
            [['project_id', 'user_id'], 'unique', 'targetAttribute' => ['project_id', 'user_id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    } */

    public function rules()
    {   
    return [
        [['project_id', 'user_id', 'userEmail', 'role_id'], 'required'],
        [['userEmail'], 'string'],
        [['project_id', 'user_id', 'role_id'], 'integer'],
        [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
    ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'role_id' => 'Role ID',
        ];
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getRolesList()
    {
        $roles = Role::find()->all();
        $rolesList = ArrayHelper::map($roles, 'id', 'nombre');
        return $rolesList;
    }
}
