<?php
header("Content-type:text/html;charset=utf-8");
function GrabImage($url,$filename="") {
    if($url==""):return false;endif;
    if($filename=="") {
        $ext=strrchr($url,".");
        if($ext!=".gif" && $ext!=".jpg"):return false;endif;
        $filename=date("dMYHis").$ext;
    }
    ob_start();
    readfile($url);
    $img = ob_get_contents();
    ob_end_clean();
    $size = strlen($img);
    $fp2=@fopen($filename, "w+");
    fwrite($fp2,$img);
    fclose($fp2);
    return $filename;
}


for($i=1;$i<8;$i++){
    $url="http://www.topit.me/popular/20120420?p=".$i;
    echo $url;
    $file=file_get_contents($url);

    $preg='/(.*)<div class="e">(.*)<\/div>(.*)/isU';
    preg_match_all($preg,$file,$string);
    set_time_limit(0);

    foreach($string[2] as $key=>$value){
        //echo $value;
        $pattern_src = '/href="(.*)"><img class="img" title="(.*)"/isU';
        preg_match_all($pattern_src,$value,$str);
        print_r($str."<br/>");

        $img=GrabImage($str[1][0],"","");

        if($img){
            echo 'sucess';
        }else{
            echo "false";
        }
    }

}
?>