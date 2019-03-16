<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $type
 * @property string $title
 * @property string $description
 * @property int $price
 * @property string $photo_base_url
 * @property string $photo_path
 * @property int $status
 * @property int $created_at
 */
class Product extends \yii\db\ActiveRecord
{
    const PRODUCT_TYPE_BURGER = 1;
    const PRODUCT_TYPE_DRINK = 2;
    const PRODUCT_TYPE_FRYER = 3;
    const PRODUCT_TYPE_EUROPE_GOODS = 4;

    const STATUS_ACTIVE = 10;
    const STATUS_DISABLED = 20;
    const STATUS_DELETED = 99;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'title', 'price'], 'required'],
            [['type', 'price', 'status', 'created_at'], 'integer'],
            [['title', 'photo_base_url', 'photo_path'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'title' => Yii::t('app', 'Название'),
            'description' => Yii::t('app', 'Описание(например, состав)'),
            'price' => Yii::t('app', 'Цена'),
            'photo_base_url' => 'Photo Base Url',
            'photo_path' => 'Photo Path',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public static function listOfProducts(): array
    {
        return [
            self::PRODUCT_TYPE_BURGER => Yii::t('app', 'Бургеры'),
            self::PRODUCT_TYPE_DRINK => Yii::t('app', 'Напитки'),
            self::PRODUCT_TYPE_FRYER => Yii::t('app', 'Закуски'),
            self::PRODUCT_TYPE_EUROPE_GOODS => Yii::t('app', 'Сладости из Европы'),
        ];
    }
}
