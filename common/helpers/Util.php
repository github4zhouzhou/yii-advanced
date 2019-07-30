<?php

namespace common\helpers;

class Util
{
	// curlFile('http://dev.account.ubfx.com/bankinfo/upload', '/data/cdn/uploads/cert/5bd2dc9ea3860.jpg');
	public function curlFile($url, $path)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);

		$data = array('file' => new \CURLFile(realpath($path)));

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 1 );
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT,"TEST");
		$result = curl_exec($curl);
		$error = curl_error($curl);

		return $result;
	}

    // 获取IP
    public static function GetIP($format = 0)
    {
        $ip = 'unknown';
        if (isset($_SERVER['HTTP_CDN_SRC_IP']) && $_SERVER['HTTP_CDN_SRC_IP'] && strcasecmp($_SERVER['HTTP_CDN_SRC_IP'], 'unknown')) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        preg_match("/[\d\.]{7,15}/", $ip, $ipMatches);
        if (!empty($ipMatches[0])) {
            $ip = $ipMatches[0];
        }
        if ($format) {
            $ips = explode('.', $ip);
            for ($i = 0; $i < 3; $i++) {
                $ips[$i] = intval($ips[$i]);
            }
            return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
        } else {
            return $ip;
        }
    }

    public static function IsPrivateIP($ip)
    {
        /*
        ip地址中预留的内网ip地址如下：
        A类： 10.0.0.0 ～ 10.255.255.255
        B类： 172.16.0.0 ～ 172.31.255.255
        C类： 192.168.0.0 ～ 192.168.255.255
        D类：127.0.0.0 ~ 127.255.255.255
        */
        $i = explode(".", $ip);
        if ($i[0] == 10) return true;
        if ($i[0] == 127) return true;
        if ($i[0] == 172 && $i[1] > 15 && $i[1] < 32) return true;
        if ($i[0] == 192 && $i[1] == 168) return true;
        return false;
    }


    public static function CheckCellphone($cellphone)
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        return self::FormatCellphone($phoneUtil, $cellphone);
    }

    public static function FormatCellphone(\libphonenumber\PhoneNumberUtil $phoneUtil, $cellphone)
    {
        $data = [];
        try {
            $cellphone = self::Sbc2Dbc($cellphone);
            // 检查手机号码，如果是以+号开头，则认为是国际号码，否则认为是用户省略输入了+
            $firstStart = substr($cellphone, 0, 1);
            if ($firstStart != '+') {
                $cellphone = '+' . $cellphone;
            }
            $cellphoneProto = $phoneUtil->parse($cellphone, null);
            $isValid = $phoneUtil->isValidNumber($cellphoneProto);
            if ($isValid) {
                $formattedCellphone = $phoneUtil->format($cellphoneProto, \libphonenumber\PhoneNumberFormat::E164);
                $country = $phoneUtil->getRegionCodeForNumber($cellphoneProto); // ISO 3166-1 国家代码, https://zh.wikipedia.org/wiki/ISO_3166-1
                $phoneCode = $phoneUtil->getCountryCodeForRegion($country);
                if (!empty($formattedCellphone) && !empty($country) && !empty($phoneCode)) {
                    $data['cellphone'] = $formattedCellphone;
                    $data['country'] = $country;
                    $data['phoneCode'] = $phoneCode;
                }
            }
        } catch (\libphonenumber\NumberParseException $e) {
            \Yii::info("[util.FormatCellphone] error: {$cellphone} | " . $e->getMessage(), __METHOD__);
        }
        return $data;
    }

    /**
     * 全角字符与成半角字符的相互转换
     * @param string $str
     * @param int $flag 0=全角到半角,1=半角到全角
     * @return string
     */
    public static function Sbc2Dbc($str, $flag = 0)
    {
        // 全角
        $SBC = array(
            '０', '１', '２', '３', '４',

            '５', '６', '７', '８', '９',

            'Ａ', 'Ｂ', 'Ｃ', 'Ｄ', 'Ｅ',

            'Ｆ', 'Ｇ', 'Ｈ', 'Ｉ', 'Ｊ',

            'Ｋ', 'Ｌ', 'Ｍ', 'Ｎ', 'Ｏ',

            'Ｐ', 'Ｑ', 'Ｒ', 'Ｓ', 'Ｔ',

            'Ｕ', 'Ｖ', 'Ｗ', 'Ｘ', 'Ｙ',

            'Ｚ', 'ａ', 'ｂ', 'ｃ', 'ｄ',

            'ｅ', 'ｆ', 'ｇ', 'ｈ', 'ｉ',

            'ｊ', 'ｋ', 'ｌ', 'ｍ', 'ｎ',

            'ｏ', 'ｐ', 'ｑ', 'ｒ', 'ｓ',

            'ｔ', 'ｕ', 'ｖ', 'ｗ', 'ｘ',

            'ｙ', 'ｚ', '－', '　', '：',

            '．', '，', '／', '％', '＃',

            '！', '＠', '＆', '（', '）',

            '＜', '＞', '＂', '＇', '？',

            '［', '］', '｛', '｝', '＼',

            '｜', '＋', '＝', '＿', '＾',

            '￥', '￣', '｀'

        );
        // 半角
        $DBC = array(
            '0', '1', '2', '3', '4',

            '5', '6', '7', '8', '9',

            'A', 'B', 'C', 'D', 'E',

            'F', 'G', 'H', 'I', 'J',

            'K', 'L', 'M', 'N', 'O',

            'P', 'Q', 'R', 'S', 'T',

            'U', 'V', 'W', 'X', 'Y',

            'Z', 'a', 'b', 'c', 'd',

            'e', 'f', 'g', 'h', 'i',

            'j', 'k', 'l', 'm', 'n',

            'o', 'p', 'q', 'r', 's',

            't', 'u', 'v', 'w', 'x',

            'y', 'z', '-', ' ', ':',

            '.', ',', '/', '%', '#',

            '!', '@', '&', '(', ')',

            '<', '>', '"', '\'', '?',

            '[', ']', '{', '}', '\\',

            '|', '+', '=', '_', '^',

            '￥', '~', '`'
        );

        //半角到全角
        if ($flag == 1) {
            return str_replace($DBC, $SBC, $str);
        } //全角到半角
        else {
            return str_replace($SBC, $DBC, $str);
        }
    }

}
