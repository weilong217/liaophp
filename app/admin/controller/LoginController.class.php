<?php
    class LoginController  extends Controller {
        public function index()
        {
            if (IS_POST){
                if($userInfo = K('User')->validate($_POST['username'],$_POST['password'])){
                    $_SESSION['username'] = $userInfo['username'];
                    $_SESSION['uid'] = $userInfo['uid'];
                    $this->success('登入成功',__APP__);
                }else{
                    $this->error('登入失败',__APP__);
                };
            }
            $this->display('login.php');
        }

        public function out(){
            session_unset();
            session_destroy();
            $this->success('退出成功',__APP__.'?c=login');
        }
    }
?>