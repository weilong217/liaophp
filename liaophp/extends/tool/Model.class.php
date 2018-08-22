<?php
class Model{
    // 保存链接信息
    public static $link = NULL;
    // 保存表名
    protected $table = NULL;
    // 初始化表信息
    private  $opt;
    // 纪录发送的 sql
    public static $sqls = [];

    public function __construct($table = NULL)
    {
        $this->table = is_null($table) ? C('DB_PREFIX') . $this->table : C('DB_PREFIX').$table;
        // 链接数据库
        $this->_connect();
        $this->_opt();
    }

    function update($data=NULL)
    {
        if (empty($this->opt['where'])) halt('更新语句必须要有 where 条件');
        if (is_null($data)) $data = $_POST;
        $values = '';
        foreach ($data as $f=>$v){
            $values .= "`" . $this->_safe_str($f) . "` = '" . $this->_safe_str($v) . "',";
        }
        $values = trim($values,',');
        $sql = "UPDATE " . $this->table . ' SET ' . $values . $this->opt['where'];
        return $this->exe($sql);
    }

    /**
     * 删除数据
     * @return mixed
     */
    function delete()
    {
        if (empty($this->opt['where'])) halt('删除语句必须要有 where 条件');
        $sql = "DELETE FROM " . $this->table . $this->opt['where'];
        return $this->exe($sql);
    }

    /**
     * 新增数据
     * @return mixed
     */
    function add($data=NULL)
    {
        if (is_null($data)) $data   = $_POST;
        $fields  = '';
        $valeus = '';
        foreach ($data as $f=>$v){
            $fields .= "`".$this->_safe_str($f)."`,";
            $valeus .= "'".$this->_safe_str($v)."',";
        }
        $fields = trim($fields, ',');
        $valeus = trim($valeus, ',');
        $sql    = 'INSERT INTO ' . $this->table .'(' . $fields . ') VALUES (' . $valeus . ')';
        return $this->exe($sql);
    }

    /**
     * 无结果集执行
     * @param $sql
     * @return mixed
     */
    public function exe($sql)
    {
        self::$sqls[] = $sql;
        $link = self::$link;
        $bool = $link->query($sql);
        $this->_opt();
        if(is_object($bool)){
            halt('请用 query 方法发送查询');
        }
        if($bool){
            return $link->insert_id ? $link->insert_id : $link->affected_rows;
        }else{
            halt('Sql错误：'.$link->error . '<br/>Sql: ' . $sql);
        };
    }

    /**
     * 查询一条数据 find 别名
     * @return array|mixed
     */
    public function one()
    {
        return $this->find();
    }

    /**
     * 查询一条数据
     * @return array|mixed
     */
    function find()
    {
        $data = $this->limit(1)->all();
        $data =current($data);
        return $data;
    }

    /**
     * 查询所有数据
     * @return array
     */
    public function all()
    {
        $sql = "SELECT " . $this->opt['field'] . " FROM " . $this->table . $this->opt['where'] . $this->opt['group'] . $this->opt['having'] . $this->opt['order'] . $this->opt['limit'];
        return $this->query($sql);
    }

    /**
     * 结果集查询
     * @param $sql
     * @return array
     */
    function query($sql)
    {
        self::$sqls = $sql;
        $link = self::$link;
        $rsult = $link->query($sql);
        if ($link->errno) halt('Sql错误：' . $link->error . '<br/>SQL: '.$sql);
        $rows = [];
        while ($row = $rsult->fetch_assoc()){
            $rows[] = $row;
        }
        $rsult->free();
        $this->_opt();
        return $rows;
    }

    public function limit($limit)
    {
        $this->opt['order'] = ' LIMIT '.$limit;
        return $this;
    }

    public function having($having)
    {
        $this->opt['having'] = ' HAVING '.$having;
        return $this;
    }

    public function group($group)
    {
        $this->opt['having'] = ' GROUP BY '.$group;
        return $this;
    }

    public function order($order)
    {
        $this->opt['order'] = ' ORDER BY '.$order;
        return $this;
    }

    public function where($where)
    {
        $this->opt['where'] = ' WHERE '.$where;
        return $this;
    }

    public function field($field)
    {
        $this->opt['field'] = $field;
        return $this;
    }

    /**
     * 初始化 sql 信息
     */
    private function _opt(){
        $this->opt = [
            'field'     =>  '*',
            'where'     =>  '',
            'group'     =>  '',
            'having'    =>  '',
            'order'     =>  '',
            'limit'     =>  ''
        ];
    }

    /**
     * 数据库链接
     */
    private function _connect()
    {
        if (is_null(self::$link))
        {
            $db = C('DB_DATABASE');
            if (empty($db)) halt('请先配置数据库');
            $link = new Mysqli(C('DB_HOTS'), C('DB_USER'), C('DB_PASSWORD'), $db, C('DB_PORT'));
            if($link->connect_error) halt('数据库链接错误！');
            $link->set_charset(C('DB_CHARSET'));
            self::$link = $link;
        }
    }

    /**
     * 添加/修改 安全处理
     * @param $str
     * @return mixed
     */
    private function _safe_str($str){
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return self::$link->real_escape_string($str);
    }
}
?>