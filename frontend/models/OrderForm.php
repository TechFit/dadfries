<?php

namespace frontend\models;

use common\models\Order;
use common\models\Product;
use Yii;
use yii\base\Model;

class OrderForm extends Model
{
    public $name;
    public $phone;
    public $address;
    public $comment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'address'], 'required'],
            [['name', 'phone'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 1024],
            [['comment'], 'string', 'max' => 2048],
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
            'address' => Yii::t('app', 'Адрес'),
            'comment' => Yii::t('app', 'Комментарий'),
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save()
    {
        if ($this->validate()) {

            $order_products = Yii::$app->getRequest()->getCookies()->getValue('order', (isset($_COOKIE['order']))? $_COOKIE['order']: 'order');

            if ($order_products) {

                $order_products = json_decode($order_products, true);

                foreach ($order_products AS $order) {

                    if (isset($order['item_id']) && isset($order['count']) && isset($order['price'])) {

                        $price = (int) $order['price'];

                        $is_exist_product = Product::find()->where(['id' => $order['item_id']])->andWhere(['price' => $price])->andWhere(['status' => Product::STATUS_ACTIVE])->exists();

                        if ($is_exist_product) {
                            $order = new Order();
                            $order->name = $this->name;
                            $order->phone = $this->phone;
                            $order->address = $this->address;
                            $order->comment = $this->comment;
                            $order->save();
                        }
                    }
                }
            }
        }

        return false;
    }
}
