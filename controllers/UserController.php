<?php

namespace app\controllers;
use app\models\UpdatePasswordForm;
use Yii;
use yii\base\Exception;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\i18n\Formatter;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\FormRegister;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\models\Users;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            */
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            if(User::lastChangePassword(Yii::$app->user->identity->id)){
                return $this->redirect(['user/updatepassword']);
            }else{
                if (User::isUserAdmin(Yii::$app->user->identity->id))
                {
                    return $this->redirect(["atendimento/index"]);
                }
                else
                {
                    return $this->redirect(["atendimento/index"]);
                }
            }
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(User::lastChangePassword(Yii::$app->user->identity->id)){
                return $this->redirect(['users/updatepassword']);
            }else {
                if (User::isUserAdmin(Yii::$app->user->identity->id)) {
                    return $this->redirect(["atendimento/index"]);
                } else {
                    return $this->redirect(["user/login"]);
                }
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(["user/login"]);
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

    public function actionRegister()
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
        return $this->render("register", ["model" => $model, "msg" => $msg]);
    }

    public function actionUpdatepassword(){
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



}
