<?php
namespace frontend\controllers;

use common\models\Product;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
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
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $products = self::prepareProducts(Product::find()->where(['status' => Product::STATUS_ACTIVE])->asArray()->all());

        return $this->render('index', [
            'products' => $products,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    private function prepareProducts(array $items): array
    {
        $products['burgers'] = [];
        $products['drinks'] = [];
        $products['fryer'] = [];
        $products['europe'] = [];

        foreach ($items AS $key => $item) {

            switch ($item['type']) {
                case Product::PRODUCT_TYPE_BURGER:
                    $products['burgers'][] = $item;
                    unset($products[$key]);
                    break;
                case Product::PRODUCT_TYPE_DRINK:
                    $products['drinks'][] = $item;
                    unset($products[$key]);
                    break;
                case Product::PRODUCT_TYPE_FRYER:
                    $products['fryer'][] = $item;
                    unset($products[$key]);
                    break;
                case Product::PRODUCT_TYPE_EUROPE_GOODS:
                    $products['europe'][] = $item;
                    unset($products[$key]);
                    break;
            }
        }

        return $products;
    }
}
