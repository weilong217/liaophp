<?php
// 分类模型
class CategoryModel extends Model{
    public $table = 'category';

    /**
     * 添加分类
     * @return mixed
     */
    function add_data(){
        return $this->add();
    }

    /**
     * 查找所有分类
     * @return array
     */
    function get_all(){
        return $this->all();
    }

    /**
     * 删除分类
     * @param $cid
     * @return mixed
     */
    function del_data($cid){
        return $this->where("cid=".$cid)->delete();
    }
}