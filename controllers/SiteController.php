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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
        return $this->render('index',
            [
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
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
        if (!Yii::$app->user->isGuest) {
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
        } else {
            Yii::$app->session->addFlash('error', "You need to sign in first");
            return $this->redirect(['site/login']);
        }
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
        if (!Yii::$app->user->isGuest) {
            $post = $this->findModel($id);
            if (Post::find()->select('user_id')->where(['id' => $id])->scalar() == Yii::$app->user->identity->getId()) {
                if ($post->load(Yii::$app->request->post()) && $post->save()) {
                    return $this->redirect(['view', 'id' => $post->id]);
                }
                return $this->render('update', [
                    'post' => $post,
                ]);
            } else {
                Yii::$app->session->addFlash('error', "You are not allowed to do that");
                return $this->redirect(['view','id' => $post->id]);
            }

        } else {
            Yii::$app->session->addFlash('error', "You need to sign in first");
            return $this->actionLogin();
        }
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->user->isGuest) {
            if (Post::find()->select('user_id')->where(['id' => $id])->scalar() == Yii::$app->user->identity->getId()) {
                $this->findModel($id)->delete();
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->addFlash('error', "You are not allowed to do that");
            }
        }
        Yii::$app->session->addFlash('error', "You need to sign in first");
        return $this->actionLogin();
    }
}