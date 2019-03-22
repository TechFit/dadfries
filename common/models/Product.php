<?php

namespace common\models;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

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

    public $photo;

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
            [['photo'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'photo',
                'pathAttribute' => 'photo_path',
                'baseUrlAttribute' => 'photo_base_url'
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false
            ]
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
            'description' => Yii::t('app', 'Описание'),
            'price' => Yii::t('app', 'Цена'),
            'photo_base_url' => 'Photo Base Url',
            'photo_path' => 'Photo Path',
            'photo' => Yii::t('app', 'Фото'),
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

    public function getPhoto(int $size = null, $default = '/images/anonymous.jpg')
    {
        if (!$this->photo_path) return $default;

        if ($size) {
            $size = $size > 350 ? 350 : ($size < 25 ? 25 : $size);

            return Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $this->photo_path, 'w' => $size], true);
        }

        return $this->photo_base_url . "/" . $this->photo_path;
    }
}
