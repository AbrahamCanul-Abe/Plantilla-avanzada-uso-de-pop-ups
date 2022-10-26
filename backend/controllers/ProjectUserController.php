<?php

namespace backend\controllers;

use yii;
use yii\helpers\ArrayHelper;

use backend\traits\EnforceProjectContextTrait; 

use backend\models\ProjectUser;
use common\models\User;
use backend\models\Role;
use backend\models\search\ProjectUserSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\db\Query; 
use yii\helpers\Json; 

/**
 * ProjectUserController implements the CRUD actions for ProjectUser model.
 */
class ProjectUserController extends Controller
{
    use EnforceProjectContextTrait;
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view','create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ]
        ];
    }

    /**
     * Lists all ProjectUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectUserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectUser model.
     * @param int $project_id Project ID
     * @param int $user_id User ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($project_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($project_id, $user_id),
        ]);
    }

    /**
     * Creates a new ProjectUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    /* public function actionCreate($project_id)
    {
    $this->loadProject($project_id);
    $model = new ProjectUser();
    $model->project_id = $project_id;

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'project_id' => $model->project_id, 'user_id' => $model->user_id]);
    } else {
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    }   */  
    
    public function actionCreate($project_id)
    {
    $this->loadProject($project_id);
    $model = new ProjectUser();
    $model->project_id = $project_id;

    if ($model->load(Yii::$app->request->post())) {
       $user = User::findByEmail($model->userEmail);
       $model->user_id = $user->id;
    }

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'project_id' => $model->project_id, 'user_id' => $model->user_id]);
    } else {
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    }


    /**
     * Updates an existing ProjectUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $project_id Project ID
     * @param int $user_id User ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($project_id, $user_id)
    {
        $model = $this->findModel($project_id, $user_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'project_id' => $model->project_id, 'user_id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProjectUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $project_id Project ID
     * @param int $user_id User ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($project_id, $user_id)
    {
        $this->findModel($project_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $project_id Project ID
     * @param int $user_id User ID
     * @return ProjectUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($project_id, $user_id)
    {
        if (($model = ProjectUser::findOne(['project_id' => $project_id, 'user_id' => $user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUserList($q = null) {
        $query = new Query;
    
        $query->select('email')
            ->from('user')
            ->where('email LIKE "%' . $q .'%"')
            ->orderBy('email');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['email']];
        }
        echo Json::encode($out);
    }
    
}
