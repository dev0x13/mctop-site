<?php

class PreVote extends CFormModel
{
    public $verifyCode;
    public $validacion;

    public function rules()
    {
        return array(
            array('validacion',
                'application.extensions.recaptcha.EReCaptchaValidator',
                'privateKey' => '6Lerl_ISAAAAAL45dp03zpGlx37O8NPrWi_HCMuw'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'validacion' => Yii::t('translations', 'Введите слова, написанные на изображении'),
        );
    }

}
