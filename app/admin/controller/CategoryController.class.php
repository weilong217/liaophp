<?php
class CategoryController extends CommonController{
    private $_model;

    public function __auto(){
        $this->_model = K('Category');
    }
    /**
     * 栏目管理
     */
    function index()
    {
        $data = $this->_model->get_all();
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 添加栏目
     */
    function add(){
        if(IS_POST){
            $this->_model->add_data();
            $this->success('添加成功！','?c=category');
        }
        $this->display();
    }

    /**
     * 删除栏目
     */
    function del(){
        $cid = (int)$_GET['cid'];
        $this->_model->del_data($cid);
        $this->success('删除成功!');
    }
}
?>