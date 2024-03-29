<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Post;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'update', 'delete', 'post', 'register', 'login'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['register', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['register', 'login'],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/site/index']);
                        }
                    ],
                    [
                        'actions' => ['update', 'delete', 'post'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update', 'delete', 'post'],
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function () {
                            Yii::$app->session->addFlash('error', "You need to sign in first");
                            return Yii::$app->controller->redirect(['/site/login']);
                        }
                    ]
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
     * {@inheritdoc}
     */
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

    /**
     * Displays Homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Post();
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'post' => $model
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays post page.
     *
     * @return string
     */
    public function actionPost()
    {
        $post = new Post();
        if ($post->load(Yii::$app->request->post())) {
            $fileName = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            $post->file = UploadedFile::getInstance($post, 'file');
            $post->user_id = Yii::$app->user->identity->getId();
            if ($post->validate()) {
                $post->post_image = 'uploads/' . $fileName . '.' . $post->file->extension;
                $post->save();
                $post->file->saveAs('uploads/' . $fileName . '.' . $post->file->extension);
                return $this->goHome();
            }
        }

        return $this->render('post', [
            'post' => $post
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $comment = new Comment();
        if ($comment->load(Yii::$app->request->post()) && !Yii::$app->user->isGuest) {
            $comment->created_at = new \yii\db\Expression('NOW()');
            $comment->post_id = $id;
            $comment->user_id = Yii::$app->user->identity->getId();
            if ($comment->validate()) {
                $comment->save();
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->select(['comments.*', 'users.username'])->joinWith('users')->where(['post_id' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'comment' => $comment
        ]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        Yii::$app->session->addFlash('error', "You need to sign in first");
        return $this->actionLogin();

        $post = $this->findModel($id);

        $result = Post::find()
            ->select('user_id')
            ->where(['id' => $id])
            ->scalar();

        if ($result != Yii::$app->user->identity->getId()) {
            Yii::$app->session->addFlash('error', "You are not allowed to do that");
            return $this->redirect(['view', 'id' => $post->id]);
        }


        if (!$post->load(Yii::$app->request->post()) || !$post->save()) {
            return $this->render('update', [
                'post' => $post,
            ]);
        }

        return $this->redirect(['view', 'id' => $post->id]);
    }

    public function actionDelete($id)
    {
        if (Post::find()->select('user_id')->where(['id' => $id])->scalar() == Yii::$app->user->identity->getId()) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->addFlash('error', "You are not allowed to do that");
        }
        Yii::$app->session->addFlash('error', "You need to sign in first");
        return $this->actionLogin();
    }

    public function actionRegister()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->rawPassword);
            $model->generateAuthKey();
            $model->save();
            Yii::$app->session->setFlash('success', "You have signed up successfully. Now you can Log In");
            return $this->redirect(['site/login']);
        }
        return $this->render('register', [
            'model' => $model
        ]);
    }
}
