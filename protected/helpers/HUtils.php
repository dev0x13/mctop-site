<?php

class HUtils
{

    public static function Parse($string, $delimitter = ',', $pattern = ':')
    {

        if (empty($string))
            return null;

        $array = explode($delimitter, $string);

        foreach ($array as $key => $value) {
            $array[$key] = str_replace($pattern, '', trim($value));
        }

        if (is_null($array))
            $array = [];

        return $array;
    }

    public static function TransformToString($array)
    {
        $string = '';

        foreach ($array as $element) {
            $element = trim($element);
            if (!empty($element))
                $string .= ':' . $element . ':, ';
        }

        $string = substr($string, 0, strlen($string) - 2);
        return $string;
    }

    public static function writeDump($array, $name)
    {
        $content = "";
        foreach ($array as $dump) {
            $content .= $dump;
        }

        $fp = fopen($name, "wb");
        fwrite($fp, $content);
        fclose($fp);
    }

    public static function json_encode_cyr($str)
    {
        $arr_replace_utf = array('\u0410', '\u0430', '\u0411', '\u0431', '\u0412', '\u0432',
            '\u0413', '\u0433', '\u0414', '\u0434', '\u0415', '\u0435', '\u0401', '\u0451', '\u0416',
            '\u0436', '\u0417', '\u0437', '\u0418', '\u0438', '\u0419', '\u0439', '\u041a', '\u043a',
            '\u041b', '\u043b', '\u041c', '\u043c', '\u041d', '\u043d', '\u041e', '\u043e', '\u041f',
            '\u043f', '\u0420', '\u0440', '\u0421', '\u0441', '\u0422', '\u0442', '\u0423', '\u0443',
            '\u0424', '\u0444', '\u0425', '\u0445', '\u0426', '\u0446', '\u0427', '\u0447', '\u0428',
            '\u0448', '\u0429', '\u0449', '\u042a', '\u044a', '\u042b', '\u044b', '\u042c', '\u044c',
            '\u042d', '\u044d', '\u042e', '\u044e', '\u042f', '\u044f');
        $arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
            'Ё', 'ё', 'Ж', 'ж', 'З', 'з', 'И', 'и', 'Й', 'й', 'К', 'к', 'Л', 'л', 'М', 'м', 'Н', 'н', 'О', 'о',
            'П', 'п', 'Р', 'р', 'С', 'с', 'Т', 'т', 'У', 'у', 'Ф', 'ф', 'Х', 'х', 'Ц', 'ц', 'Ч', 'ч', 'Ш', 'ш',
            'Щ', 'щ', 'Ъ', 'ъ', 'Ы', 'ы', 'Ь', 'ь', 'Э', 'э', 'Ю', 'ю', 'Я', 'я');
        $str1 = json_encode($str);
        $str2 = str_replace($arr_replace_utf, $arr_replace_cyr, $str1);
        return $str2;
    }

    public static function getCurrentTimestamp()
    {
        return date('Y-m-d H:i:s', time());
    }

    public static function sendForumApiRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    public static function isItValidLink($string)
    {
        return preg_match('~^(?:(?:https?|ftp|telnet)://(?:[a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:ru|dev|su|com|net|org|mil|edu|arpa|gov|biz|info|aero|inc|name|im|[a-z]{2})|(?!0)(?:(?!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&?+=\~/-]*)?(?:#[^ \'\"&]*)?$~i', $string);
    }

    public static function getUserTimeZoneNameByGMT($gmt)
    {
        //todo Хорошая задумка с изменением стиля сайта на ночной в ночное время.
        // Но для этого нужно узнать временную зону юзера.
        return $gmt;
    }

    public static function sendAjaxGetRequest($url, $params)
    {
        if (!is_array($params))
            throw new Exception('$params must be an array');

        $i = 0;
        $get_params = '';
        foreach ($params as $key => $param) {
            $string = $key . '=' . $param;
            $get_params .= $i == 0 ? '?' : '&';
            $get_params .= $string;
            $i++;
        }


        $curlInit = curl_init();
        curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curlInit, CURLOPT_URL, ($url . $get_params));
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, '1');
        curl_setopt($curlInit, CURLOPT_TIMEOUT, 1000);
        $result = curl_exec($curlInit);
        curl_close($curlInit);

        if ($result)
            return $result;
        return
            array('result' => 'error', 'message' => 'site not available');
    }

    public static function sendAjaxGetRequestWithoutParamsArray($url)
    {

        $curlInit = curl_init();
        curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curlInit, CURLOPT_URL, ($url));
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, '1');
        curl_setopt($curlInit, CURLOPT_TIMEOUT, 1000);
        $result = curl_exec($curlInit);
        curl_close($curlInit);

        return $result;
    }

    public static function createPacketForAjax($name, $value)
    {
        return array($name => $value);
    }


}