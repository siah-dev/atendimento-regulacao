<?php

namespace app\controllers;
use app\models\ResetPasswordForm;
use app\models\UpdatePasswordForm;
use app\models\User;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Users;
use app\models\UsersSearch;
use app\models\FormRegister;
use yii\web\Response;
use app\components\AccessRule;

class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = 'painel';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['create','update','updatepassword','randkey','delete'],
                'rules' => [
                    [
                        'actions'=>['create','update','updatepassword','randkey','delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //Creamos la instancia con el model de validación
        $model = new FormRegister;

        //Mostrará un mensaje en la vista cuando el usuario se haya registrado
        $msg = null;

        //Validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        //Validación cuando el formulario es enviado vía post
        //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
        //También previene por si el usuario tiene desactivado javascript y la
        //validación mediante ajax no puede ser llevada a cabo
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                //Preparamos la consulta para guardar el usuario
                $table = new Users;
                $table->name = $model->name;
                $table->username = $model->username;
                $table->email = $model->email;
                //Encriptamos el password
                $table->password = crypt($model->password, Yii::$app->params["salt"]);
                //Creamos una cookie para autenticar al usuario cuando decida recordar la sesión, esta misma
                //clave será utilizada para activar el usuario
                $table->authKey = $this->randKey("abcdef0123456789", 200);
                //Creamos un token de acceso único para el usuario
                $table->accessToken = $this->randKey("abcdef0123456789", 200);
                $table->activate = 1;
                $table->role = $model->role;
                //Si el registro es guardado correctamente
                if ($table->insert())
                {
                    $model->username = null;
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;
                    $msg = "Parabéns, usuário regisitrado com sucesso";
                }
                else
                {
                    $msg = "Ocorreu um erro na execução de seu registro";
                }

            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("create", ["model" => $model, "msg" => $msg]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelPassword = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelPassword'=>$modelPassword
            ]);
        }
    }

    public function actionResetpassword(){
        $model = new ResetPasswordForm();
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                try{
                    $modeluser = $this->findModel($model->id_user);
                    $modeluser->password = crypt($model->newpassword,Yii::$app->params['salt']);
                    $modeluser->lastChangePassword = Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s'),'php:Y-m-d H:i:s');
                    if($modeluser->save()){
                        Yii::$app->getSession()->setFlash(
                            'success','Senha alterada'
                        );
                        return $this->redirect(['users/index']);
                    }else{
                        Yii::$app->getSession()->setFlash(
                            'error','Senha não alterada'
                        );
                        return $this->redirect(['users/index']);
                    }
                }catch(Exception $e){
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('view',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('update',[
                    'model'=>$model
                ]);
            }
        }else{
            return $this->render('update',[
                'model'=>$model
            ]);
        }
    }

    public function actionUpdatepassword(){
        $this->layout = 'main';
        $model = new UpdatePasswordForm();
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                try{
                    $modeluser = Users::find()->where([
                        'id'=>Yii::$app->user->identity->id
                    ])->one();
                    $modeluser->password = crypt($model->newpassword,Yii::$app->params['salt']);
                    $modeluser->lastChangePassword = Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s'),'php:Y-m-d H:i:s');
                    if($modeluser->save()){
                        Yii::$app->getSession()->setFlash(
                            'success','Senha alterada'
                        );
                        return $this->redirect(['atendimento/index']);
                    }else{
                        Yii::$app->getSession()->setFlash(
                            'error','Senha não alterada'
                        );
                        return $this->redirect(['atendimento/index']);
                    }
                }catch(Exception $e){
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('updatepassword',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('updatepassword',[
                    'model'=>$model
                ]);
            }
        }else{
            return $this->render('updatepassword',[
                'model'=>$model
            ]);
        }
    }
    private function randKey($str='', $long=0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for($x=0; $x<$long; $x++)
        {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
