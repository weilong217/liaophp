<?php

/**
 * 文章模型类
 * Class ArticleModel
 */
class ArticleModel extends Model{
    public $table = 'article';

    function add_data(){
        if (!$this->validata()) return false;
        $_POST['sendtime'] = time();
        return $this->add();
    }

    /**
     * 验证
     * @return bool
     */
    public function validata(){
        return true;
    }
}
?>