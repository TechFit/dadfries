<?php

namespace frontend\models;

use common\models\Order;
use common\models\OrderProduct;
use common\models\Product;
use TelegramBot\Api\BotApi;
use Yii;
use yii\base\Model;

class OrderForm extends Model
{
    public $name;
    public $phone;
    public $address;
    public $delivery;
    public $comment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => Yii::t('app', 'Укажите, пожалуйста, имя')],
            ['phone', 'required', 'message' => Yii::t('app', 'Укажите, пожалуйста, телефон')],
            ['delivery', 'required', 'message' => Yii::t('app', 'Укажите, пожалуйста, адрес доставки')],
            ['name', 'string', 'length' => [3, 24], 'tooShort' => Yii::t('app', 'Минимальная длина имени 3 символа')],
            ['delivery', 'string', 'length' => [5, 255], 'tooShort' => Yii::t('app', 'Минимальная длина имени 5 символа')],
            ['comment', 'string', 'length' => [5, 1024], 'tooShort' => Yii::t('app', 'Минимальная длина имени 5 символа')],
            [['address'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Имя'),
            'phone' => Yii::t('app', 'Телефон'),
            'delivery' => Yii::t('app', 'Адрес доставки'),
            'comment' => Yii::t('app', 'Комментарий'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save()
    {
        $telegram_bot = new BotApi('761314760:AAEjqje1JS8mSZqRpUlVHK8E2pZX3Qweu_A');

        if ($this->validate()) {

            $order_products = Yii::$app->getRequest()->getCookies()->getValue('order', (isset($_COOKIE['order']))? $_COOKIE['order']: 'order');

            if ($order_products) {

                $order_products = json_decode($order_products, true);

                $message = "";

                $order_list = "";

                $fullPrice = 0;

                $db = Yii::$app->db;

                $transaction = $db->beginTransaction();

                try {

                    $order_db = new Order();

                    $order_db->name = $this->name;

                    $order_db->phone = $this->phone;

                    $order_db->address = $this->delivery;

                    $order_db->comment = $this->comment;

                    $order_db->save();

                    foreach ($order_products AS $order) {

                        if (isset($order['item_id']) && isset($order['count']) && isset($order['price'])) {

                            $price = (int) $order['price'];

                            $exist_product = Product::find()->select('id')->where(['id' => $order['item_id']])->andWhere(['price' => $price])->andWhere(['status' => Product::STATUS_ACTIVE])->scalar();

                            if ($exist_product) {

                                $fullPrice += $order['price'] * $order['count'];

                                $order_list .= $order['count'] . " x " . $order['name'] . ' - ' . $order['price'] * $order['count'] . " .p\n";

                                $order_product = new OrderProduct();

                                $order_product->product_id = $exist_product;

                                $order_product->order_id = $order_db->id;

                                $order_product->save();

                            } else {
                                $telegram_bot->sendMessage('-1001235606537',  'Ошибка при заказе, номер клиента - ' . $this->phone);

                                return false;
                            }
                        }
                    }

                    $message = "<b>ЗАКАЗ №" . $order_db->id . ' ' . date("Y-m-d H:i") . "</b>\n\n";

                    $message .= $order_list . "\n";

                    $message .= "<b>Итого</b> - " . $fullPrice . " .р \n";

                    $message .= "_________________________ \n";

                    $message .= "Имя: " . $this->name . "\n";
                    $message .= "Телефон: " . $this->phone . "\n";
                    $message .= "Адрес: " . $this->delivery . "\n";
                    if ($this->comment) {
                        $message .= "Комментарий: " . $this->comment . "\n";
                    }

                    $telegram_bot->sendMessage('-1001235606537',  $message, 'html');

                    Yii::$app->getResponse()->getCookies()->remove('order');

                    $transaction->commit();

                    return true;

                } catch(\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch(\Throwable $e) {
                    $transaction->rollBack();
                }
            }
        }

        return false;
    }
}
