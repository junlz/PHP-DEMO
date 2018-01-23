<?php
/**
 * FunctionHelper
 */
class FunctionHelper {
    // --------------------------------------------------------------------
    /**
     * httpPost
     *
     * @param  string $url
     * @param  array $param
     * @return array|bool
     */
    public static function httpPost( $url, array $param ){
        if( empty($url) || empty($param) ){
            return false;
        }
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $param);
        $strRes = curl_exec($ch);
        curl_close( $ch );
        $arrResponse = json_decode( $strRes, true );
        // if( $arrResponse['status']==0 ) {
        //  echo iconv('UTF-8','GBK', $arrResponse['err_msg'])."\n";
        // } else {
        //  return $arrResponse;
        // }
        return $arrResponse;
    }
    // --------------------------------------------------------------------
    /**
     * 使用DWZ生产短网址服务
     *
     * @see    http://dwz.cn/
     * @param  string $url
     * @return array|bool
     */
    public static function createTinyUrl( $url='' ){
        if( $url ){
            $targetURL = 'http://dwz.cn/create.php';
            $param = array(
                'url' => $url,
            );
            $result = self::httpPost( $targetURL, $param );
            if( $result['status'] == 0 ){
                return $result;
            } else {
                return false;
            }
        }
    }
    // --------------------------------------------------------------------
}

// 测试
$strLongUrl = "http://my.oschina.net/wangyongtao";
$arrTinyUrlResult = FunctionHelper::createTinyUrl( $strLongUrl );
print_r($arrTinyUrlResult);
// $ php dwz_test.php
// Array
// (
//     [tinyurl] => http://dwz.cn/30R23W
//     [status] => 0
//     [longurl] => http://my.oschina.net/wangyongtao
//     [err_msg] =>
// )

<?php
/**
 * FunctionHelper
 */
class FunctionHelper {
    // --------------------------------------------------------------------
    /**
     * httpPost
     *
     * @param  string $url
     * @param  array $param
     * @return array|bool
     */
    public static function httpPost( $url, array $param ){
        if( empty($url) || empty($param) ){
            return false;
        }
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $param);
        $strRes = curl_exec($ch);
        curl_close( $ch );
        $arrResponse = json_decode( $strRes, true );
        // if( $arrResponse['status']==0 ) {
        //  echo iconv('UTF-8','GBK', $arrResponse['err_msg'])."\n";
        // } else {
        //  return $arrResponse;
        // }
        return $arrResponse;
    }
    // --------------------------------------------------------------------
    /**
     * 使用DWZ生产短网址服务
     *
     * @see    http://dwz.cn/
     * @param  string $url
     * @return array|bool
     */
    public static function createTinyUrl( $url='' ){
        if( $url ){
            $targetURL = 'http://dwz.cn/create.php';
            $param = array(
                'url' => $url,
            );
            $result = self::httpPost( $targetURL, $param );
            if( $result['status'] == 0 ){
                return $result;
            } else {
                return false;
            }
        }
    }
    // --------------------------------------------------------------------
}

// 测试
$strLongUrl = "http://my.oschina.net/wangyongtao";
$arrTinyUrlResult = FunctionHelper::createTinyUrl( $strLongUrl );
print_r($arrTinyUrlResult);
// $ php dwz_test.php
// Array
// (
//     [tinyurl] => http://dwz.cn/30R23W
//     [status] => 0
//     [longurl] => http://my.oschina.net/wangyongtao
//     [err_msg] =>
// )