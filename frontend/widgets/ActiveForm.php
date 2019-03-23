<?php

namespace frontend\widgets;


use Yii;
use yii\bootstrap\Html;

class ActiveForm extends \yii\bootstrap\ActiveForm
{
    public $layout = 'horizontal';

    public $enableClientValidation = false;

    public $enableAjaxValidation = true;

    public $validateOnChange = false;

    public $validateOnType = false;

    public function init()
    {
        parent::init();

        $this->options['autocomplete'] = 'false';

        $this->fieldConfig = [
            'checkboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}\n{hint}",
            'radioTemplate' => "{beginWrapper}\n<div class=\"radio\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}</div>\n{error}\n{endWrapper}\n{hint}\n",
            'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}\n{hint}",
            'horizontalRadioTemplate' => "{beginWrapper}\n<div class=\"radio\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}\n{hint}",
        ];

        $this->view->registerJs(<<<JS
        $("#{$this->id}").on('beforeValidate', function(e) { console.log('beforeValidate'); $(this).find('button[type=submit]').prop('disabled', 1); });
        $("#{$this->id}").on('afterValidate', function(e) { console.log('afterValidate'); $(this).find('button[type=submit]').prop('disabled', 0); });
        $("#{$this->id}").on('beforeSubmit', function(e) { console.log('beforeSubmit');
            var self = $(this); 
            self.find('button[type=submit]').prop('disabled', 1);
            self.find('button[type=submit]').html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + self.find('button[type=submit]').text())
            setTimeout(function() {
                self.find('button[type=submit]').prop('disabled', 0);
                self.find('button[type=submit]').html(self.find('button[type=submit]').text())
            }, 5000);
        });
JS
);
    }

    public static function actions($isNewRecord = true, $cancelUrl = ['index'], $confirm = false)
    {
        return Html::tag('div',
            Html::tag('div',
                Html::submitButton($isNewRecord ? Yii::t('app', 'Додати') : ($confirm ? Yii::t('app', 'Підтвердити') : Yii::t('app', 'Зберегти')), ['class' => $isNewRecord ? 'btn btn-primary' : 'btn btn-success']).
                ($cancelUrl ? Html::a(Yii::t('app', 'Скасувати'), $cancelUrl, ['class'=>'btn btn-default']) : '')
                , ['class' => 'btn-group'])
            , ['class' => 'form-group text-center', 'style' => 'margin-bottom: 0;']);
    }

    public static function actionsModal($isNewRecord = true)
    {
        return Html::tag('div',
            Html::tag('div',
                Html::submitButton($isNewRecord ? Yii::t('app', 'Додати') : (Yii::t('app', 'Зберегти')), ['class' => $isNewRecord ? 'btn btn-primary' : 'btn btn-success']).
                (Html::a(Yii::t('app', 'Скасувати'), 'javascript:;', ['class'=>'btn btn-default', 'data' => ['dismiss' => 'modal']]))
                , ['class' => 'btn-group'])
            , ['class' => 'form-group text-center', 'style' => 'margin-bottom: 0;']);
    }
}