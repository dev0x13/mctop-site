<?php

class HUnitPay
{
    /**
     * Формирование цифровой подписи для массива параметров
     *
     * @param array $params
     * @param string $secretKey
     * @return string
     */
    static function md5sign($params, $secretKey)
    {
        ksort($params);
        unset($params['sign']);

        return md5(join(null, $params) . $secretKey);
    }

    /**
     * Ошибочный ответ партнера
     *
     * @param $message
     */
    static function responseError($message)
    {
        $error = array(
            "jsonrpc" => "2.0",
            "error" => array(
                "code" => -32000,
                "message" => $message
            ),
            'id' => 1
        );
        echo HUtils::json_encode_cyr($error);
        exit();
    }

    /**
     * Успешный ответ партнера
     *
     * @param $message
     */
    static function responseSuccess($message)
    {
        $success = array(
            "result" => array(
                "message" => $message
            ),
        );
        echo HUtils::json_encode_cyr($success);
        Yii::app()->end();
    }

}