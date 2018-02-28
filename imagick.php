<?php
/**
 * PDF2PNG
 * @param $pdf  待处理的PDF文件
 * @param $path 待保存的图片路径
 * @param $page 待导出的页面 -1为全部 0为第一页 1为第二页
 * @return      保存好的图片路径和文件名
 */
function pdf2png($PDF,$Path){
    if(!extension_loaded('imagick')){
        return false;
    }
    if(!file_exists($PDF)){
        return false;
    }
    $IM = new imagick();
    $IM->setResolution(120,120);
    $IM->setCompressionQuality(100);
    $IM->readImage($PDF);
    foreach ($IM as $Key => $Var){
        $Var->setImageFormat('png');
        $Filename = $Path.'/'.md5($Key.time()).'.png';
        if($Var->writeImage($Filename) == true){
            $Return[] = $Filename;
        }
    }
    return $Return;
}
$s=pdf2png('file/abc.pdf','images');
print_r($s);
?>