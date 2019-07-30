<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Image;
use app\models\Post;
use app\models\PostTranslation;
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
        $model = new PostTranslation();
        $dataProvider = new ActiveDataProvider([
            'query' => PostTranslation::find(),
            //->where(['locale' => 'en-US']),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);
        //var_dump($model->load(Yii::$app->request->post()));exit;
        if ($model->load(Yii::$app->request->post())) {
            $dataProvider = new ActiveDataProvider([
                'query' => PostTranslation::find()->where(['locale' => 'en-US']),
                'pagination' => [
                    'pageSize' => 20,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_ASC,
                    ]
                ],
            ]);
        }
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
        $upload = new Image();
        $postTranslation_eng = new PostTranslation();
        $postTranslation_geo = new PostTranslation();
        $postTranslation_rus = new PostTranslation();
        $post = new Post();

        $postTranslationData = Yii::$app->request->post('PostTranslation');


        if ($post->load(Yii::$app->request->post()) && $upload->load(Yii::$app->request->post())) {

            foreach ($postTranslationData as $data => $value) {
                if ($data == 'eng') {
                    $postTranslation_eng->post_title = $value['post_title'];
                    $postTranslation_eng->post_description = $value['post_description'];
                    $postTranslation_eng->post_short_description = $value['post_short_description'];
                    $postTranslation_eng->locale = $value['locale'];

                } elseif ($data == 'geo') {
                    $postTranslation_geo->post_title = $value['post_title'];
                    $postTranslation_geo->post_description = $value['post_description'];
                    $postTranslation_geo->post_short_description = $value['post_short_description'];
                    $postTranslation_geo->locale = $value['locale'];
                } else {
                    $postTranslation_rus->post_title = $value['post_title'];
                    $postTranslation_rus->post_description = $value['post_description'];
                    $postTranslation_rus->post_short_description = $value['post_short_description'];
                    $postTranslation_rus->locale = $value['locale'];
                }
            }
//            var_dump($postTranslationData);
//            exit;

            $filesName = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')) . rand(1, 999);
            $fileName = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')) . rand(1, 999);
            $upload->image = UploadedFile::getInstances($upload, 'image');
            $post->file = UploadedFile::getInstance($post, 'post_image');
            $post->user_id = Yii::$app->user->identity->getId();
            $post->post_image = $fileName . '.' . $post->file->extension;


            if ($post->validate()) {
                if ($post->save()) {
                    $post->file->saveAs('uploads/' . $post->post_image);

                    $postTranslation_eng->post_id = $post->id;
                    $postTranslation_geo->post_id = $post->id;
                    $postTranslation_rus->post_id = $post->id;

                    if ($postTranslation_eng->validate() &&
                        $postTranslation_geo->validate() &&
                        $postTranslation_rus->validate()) {
                        if ($postTranslation_eng->save() && $postTranslation_geo->save() && $postTranslation_rus->save()) {
                            foreach ($upload->image as $image) {
                                $model = new Image();
                                $model->post_id = $post->id;
                                $model->image = $filesName . '.' . $image->extension;
                                if ($model->save(false)) {
                                    $image->saveAs('uploads/' . $model->image);
                                }
                            }
                            return $this->goHome();
                        }
                        return var_dump($postTranslation_eng->save() && $postTranslation_geo->save() && $postTranslation_rus->save());
                    } else {
                        var_dump($postTranslation_eng->errors);
                        var_dump($postTranslation_geo->errors);
                        var_dump($postTranslation_rus->errors);
                        exit;
                    }


                    //return var_dump($postTranslation_1->validate(), $postTranslation_2->validate(), $postTranslation_3->validate());
                }
            }

        }

//        $postTranslation_1->post_title =
//        var_dump(Yii::$app->request->post());
//        var_dump($postTranslation_2->load(Yii::$app->request->post()));
//        var_dump($postTranslation_3->load(Yii::$app->request->post()));
//       exit;

        return $this->render('post', [
            'upload' => $upload,
            'post' => $post,
            'postTranslation_eng' => $postTranslation_eng,
            'postTranslation_geo' => $postTranslation_geo,
            'postTranslation_rus' => $postTranslation_rus,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @param string $lang
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionView($id, $lang)
    {
        $postTranslation = PostTranslation::find()->where(['post_id' => $id,'locale'=>$lang])->one();
        $comment = new Comment();
        if ($comment->load(Yii::$app->request->post())) {
            $comment->created_at = new \yii\db\Expression('NOW()');
            $comment->post_id = $id;
            $comment->user_id = Yii::$app->user->identity->getId();
            if ($comment->validate()) {
                if ($comment->save()) {
                    $this->refresh();
                }
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()
                ->select(['comments.*', 'users.username'])
                ->joinWith('users')
                ->where(['post_id' => $id]),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);

        $postDataProvider = new ActiveDataProvider([
            'query' => PostTranslation::find()
                ->where(['post_id' => $id, 'locale' => $lang]),
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
            'model' => $postTranslation,
            'dataProvider' => $dataProvider,
            'comment' => $comment,
            'postDataProvider' => $postDataProvider
        ]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
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
     * @param string $lang
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public
    function actionUpdate($id, $lang)
    {
        $postTranslation = PostTranslation::find()
            ->where(['post_id'=>$id,'locale'=>$lang])
            ->one();
        $result = Post::find()
            ->select('user_id')
            ->where(['id' => $id])
            ->scalar();
        if ($result != Yii::$app->user->identity->getId()) {
            Yii::$app->session->addFlash('error', "You are not allowed to do that");
            return $this->redirect(['view', 'id' => $postTranslation->post_id]);
        }


        if (!$postTranslation->load(Yii::$app->request->post()) || !$postTranslation->save()) {
            return $this->render('update', [
                'postTranslation' => $postTranslation,
            ]);
        }

        return $this->redirect(['view', 'id' => $postTranslation->post_id,'lang'=>$postTranslation->locale]);
    }

    public
    function actionDelete($id)
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

    public
    function actionRegister()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->rawPassword);
            $model->generateAuthKey();
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "You have signed up successfully. Now you can Log In");
                return $this->redirect(['site/login']);
            }
        }
        return $this->render('register', [
            'model' => $model
        ]);
    }
}
