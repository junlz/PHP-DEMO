<?php
header('content-type:text/html;charset=utf8');
//1.初始化，创建一个新cURL资源
$curl=curl_init();
//2.设置URL和相应的选项,我们采集https://www.shiyanlou.com/
curl_setopt($curl, CURLOPT_URL, "https://www.shiyanlou.com/courses/");
//如果你想把一个头包含在输出中，设置这个选项为一个非零俼
curl_setopt($curl, CURLOPT_HEADER, 1);
// 执行之后不直接打印出朼
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//跳过证书检测 0 或 false
curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
//3.执行并获取结松
$resault=curl_exec($curl);
//释放CURL
curl_close($curl);
//匹配标题
preg_match_all("/<div class=\"course-name\">(.*?)<\/div>/",$resault, $out, PREG_SET_ORDER);
//匹配图片
preg_match_all("/https\:\/\/dn-simplecloud.shiyanlou.com\/(.*?)g/",$resault, $images, PREG_SET_ORDER);
//print_r(get_title($out));
print_r(get_img($images));
//列出标题
function get_title($res=array()){
    foreach($res as $key => $value){
        $contents[] = $value[1];

    }
    return $contents;
}
//列出图片
function get_img($res=array()){
    foreach($res as $key => $value){
        $contents[] = $value[0];

    }
    return $contents;
}


?>