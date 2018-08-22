<?php
class CommonController extends Controller{

    // 验证是否登入
    public function __init(){
        if(!isset($_SESSION['uid']) || !isset($_SESSION['username'])){
            go(__APP__ .'?c=Login');
        }
    }
}
?>