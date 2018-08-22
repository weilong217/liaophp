<?php
class IndexController extends Controller
{
    public function index()
    {
        $data = M('users')->find();
        p($data);
    }
}
?>