<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\Product;
use frontend\models\OrderForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


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
                        'actions' => ['index', 'order', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'order', 'error'],
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

    public function actionOrder()
    {
        $model = new OrderForm();

        $order_products = Yii::$app->getRequest()->getCookies()->getValue('order', (isset($_COOKIE['order']))? $_COOKIE['order']: 'order');

        if($model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success', 'You have entered data successfuly!');
        }

        return $this->render('order', [
            'model' => $model,
            'order_products' => $order_products,
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
