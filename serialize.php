<?php
class fobnn
{
    private $hack_name;
    public function __construct($name)
    {
        $this->hack_name = $name;
    }
    public function print()
    {
        echo $this->hack_name;
    }
}
$obj = new fobnn('fobnn');
$obj->print();
$serializedstr = serialize($obj); //通过serialize接口序列化
echo '<br />';
$toobj = unserialize($serializedstr);//通过unserialize反序列化
$toobj->print();

?>