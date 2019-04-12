<?php

namespace frontend\models;

use common\models\Review;
use Yii;
use yii\base\Model;

/**
 * ReviewForm is the model behind the contact form.
 */
class ReviewForm extends Model
{
    public $name;
    public $phone;
    public $message;
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => Yii::t('app', 'Укажите, пожалуйста, имя')],
            ['phone', 'integer'],
            ['message', 'required', 'message' => Yii::t('app', 'Нужно заполнить поле')],
            ['name', 'string', 'length' => [3, 24], 'tooShort' => Yii::t('app', 'Минимальная длина имени 3 символа')],
            ['message', 'string', 'length' => [5, 1024], 'tooShort' => Yii::t('app', 'Минимальная длина 5 символов')],
            ['verifyCode', 'captcha', 'message' => Yii::t('app', 'Не правильная Captcha')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Captcha',
            'name' => 'Имя',
            'phone' => 'Телефон (не обязательно)',
            'message' => 'Отзыв/замечание/пожелание',
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            $model = new Review();
            $model->name = $this->name;
            $model->phone = $this->phone;
            $model->message = $this->message;
            $model->created_at = strtotime('now');
            if ($model->save()) {
                return true;
            }
        } else {
            return false;
        }
    }
}
