<?php
class UserModel extends Model{
    public $table = 'users';

    public function validate($username, $password){
        if (!$username) return false; // 验证用户名
        $userInfo = $this->where('username="' . $username . '"')->find();
        if (!$userInfo) return false;  // 验证用户是否存在
        if($userInfo['passwrod'] != md5($password)) return false;  // 验证密码是否正确
        return $userInfo;
    }
}