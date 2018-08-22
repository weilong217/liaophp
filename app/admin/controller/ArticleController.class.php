<?php
class ArticleController extends CommonController {

    /**
     * 文章管理
     */
    public function index(){

        $this->display();
    }

    /**
     * 添加文章
     */
    public function add(){
        if (IS_POST){
            K('Article')->add_data();
        }
        $cateDate = K('category')->get_all();
        $this->assign('cateDate',$cateDate);
        $this->display();
    }

    /**
     * 删除文章
     */
    public function delete(){

        $this->display();
    }

    /**
     * 编辑文章
     */
    public function edit(){

        $this->display();
    }
}