<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );

/**
 * ģ�Ͳ����Ļ���
 * ���Բ������б�ӳ����
 * @author michael
 * @version 3.0
 */

abstract class Model {
	public $_db;
	public $_tablename;
	public $_replace = 0;
	public static $pk = NULL;
	public static $pk_val = NULL;
	public static $_data = array ();
	public static $_where = NULL;
	public static $_instance = null;
	
	public function __construct($table_name = null) {
		$this->_db = Database::instance ();
		$this->_tablename = '`' . DBNAME . '`.`' . TABLEPRE . $table_name . '`';
	}
	/**
	 *
	 * @param string $table_name
	 *        	���� ,����Ҫ�ӱ�ǰ׺
	 *        	,����Ϊkeke_witkey_link ����дΪwiktye_link
	 * @return Model
	 */
	public static function factory($table_name) {
		if (self::$_instance [$table_name] == null) {
			$class = TABLEPRE . $table_name;
			self::$_instance [$table_name] = new $class ();
		}
		
		return self::$_instance [$table_name];
	}
	/**
	 *��������
	 * @return Model
	 */
	//abstract public function setWhere($where);
	public function setWhere($value) {
		self::$_where = $value;
		return $this;
	}
	
	public function getWhere() {
		return self::$_where;
	}
	
	/**
	 * �ֶ���ֵ,ֻ����ӣ�������Ч
	 * 
	 * @param $array �ֶν�ֵ������        	
	 * @return Model
	 */
	//abstract public function setData($array);
	
	public function setData($array) {
		self::$_data = array_filter ( $array, array (
				'Model',
				'remove_null'
		) );
		return $this;
	}
	/**
	 * ��������
	 */
	function create($return_last_id = 1) {
		$res = $this->_db->insert ( $this->_tablename, self::$_data, $return_last_id, $this->_replace );
		$this->reset ();
		return $res;
	}
	/**
	 * ��������
	 */
	 
	function update() {
		if ($this->getWhere ()) {
			$res = $this->_db->update ( $this->_tablename, self::$_data, $this->getWhere () );
		} elseif (isset ( self::$pk_val )) {
			self::$_where = array (
					self::$pk => self::$pk_val
			);
				
			$res = $this->_db->update ( $this->_tablename, self::$_data, $this->getWhere () );
		}
		$this->reset ();
		return $res;
	}
	/**
	 *
	 * @param string $fields
	 *        	��ѯ�ֶΣ�Ĭ��ֵΪ*
	 * @param int $cache_time
	 *        	null ��ʾĬ�ϻ���,0 ��ʾ�����棬1����ʾ����1����
	 * @param
	 *        	array
	 */
	 
	function query($fields = '*', $cache_time = 0) {
		empty ( $fields ) and $fields = '*';
		if ($this->getWhere ()) {
			$sql = "select $fields from $this->_tablename where " . $this->getWhere ();
		} else {
			$sql = "select $fields from $this->_tablename";
		}
		empty ( $fields ) and $fields = '*';
		$this->reset ();
		//DB::query($sql)->cached()->execute();
		return $this->_db->cached ( $cache_time )->cache_data ( $sql );
	}
	/**
	 * ɾ����¼
	 */
	
	function del() {
		if ($this->getWhere ()) {
			$sql = "delete from $this->_tablename where " . $this->getWhere ();
		} else if(isset(self::$pk_val)){
			$sql = "delete from $this->_tablename where ".self::$pk." = ".self::$pk_val;
		}
		$this->reset ();
		if($sql){
			return $this->_db->query ( $sql, Database::DELETE );
		}
		return 0;
	}
	/**
	 * ͳ�Ƽ�¼��
	 */
	function count() {
		if ($this->getWhere ()) {
			$sql = "select count(*) as count from $this->_tablename where " . $this->getWhere ();
		} else {
			$sql = "select count(*) as count from $this->_tablename";
		}
		$this->reset ();
		return $this->_db->get_count ( $sql );
	}
	
	function reset() {
		self::$_where = NULL;
	}
	
	
	
	
/**
 * ��ȡ��������
 * @param String $fields  �ֶ�  ����
 * @param String  $wh   ֻ֧���ִ� ����
 * @param String $uri  ��תurl ����
 * @param String $order  �����ִ� ����
 * @param int $page   ��ǰҳ�� ��ѡ
 * @param Int $page_size  ��ǰҳ������  ��ѡ
 * @param string $ajax_dom  ajax div ��ǩ id  ��ѡ 
 * @return array(data,pages)
 */
	function get_grid($fields ,$wh = '1=1', $uri=NULL, $order = null,$page=1, $page_size = 10, $ajax_dom = null) {
		
		//$page or $page = 1;
		//$page_size or $page_size = 10;
		if(isset($_GET['page'])){
			$page = (int)$_GET['page'];
		}else{
			$page = 1;
		}
		if(isset($_GET['page_size'])){
			$page_size = (int)$_GET['page_size'];
		}else{
			$page_size = 10;
		}
		
		
		$page_obj = new Page();
		if ($ajax_dom) {
			$page_obj->setAjax ( '1' );
			$page_obj->setAjaxDom ( $ajax_dom );
		}
		if ( $wh ) {
			//�ַ�����
			$where = $wh;
		}else{
			$where = ' 1=1 ';
		}
		if(isset($_GET['count'])){
			$count = (int)$_GET['count'];
		}
		//ͳ�Ʊ���ܼ�¼��,���count��ֵ�����ٴβ�ѯ��ȷ����ҳֻ��һ�β�ѯ
		if(!$count){
			$this->setWhere($where);
			$count = $this->count();
		}
		if(!$uri){
			$uri = BASE_URL.'/'.Request::current()->url();
		}
		$pages = $page_obj->getPages ( $count, $page_size, $page, $uri );
		$where .= $order .= $pages ['where'];
		$this->setWhere ( $where );
		$res_info = array();
		$res_info ['data'] = $this->query($fields);
		$res_info ['pages'] = $pages;
		return $res_info;
	}
	/**
	 * ����ҳ����
	 * @param string $sql  ����
	 * @param string $wh ����
	 * @param string $uri ����
	 * @param string $order ����
	 * @param string $group_by ��ѡ
	 * @param int $page ��ѡ
	 * @param int $page_size ��ѡ
	 * @param bool $ajax_dom ��ѡ
	 * @return array(data,pages)
	 */
	public static function sql_grid($sql ,$wh = '1=1', $uri=NULL, $order = null,$group_by = null,$page=1, $page_size = 10, $ajax_dom = null) {
	
		if(isset($_GET['page'])){
			$page = (int)$_GET['page'];
		}else{
			$page = 1;
		}
		if(isset($_GET['page_size'])){
			$page_size = (int)$_GET['page_size'];
		}else{
			$page_size = 10;
		}
		
		$page_obj = new Page();
		if ($ajax_dom) {
			$page_obj->setAjax ( '1' );
			$page_obj->setAjaxDom ( $ajax_dom );
		}
		$where = ' where ';
		if ( $wh ) {
			//�ַ�����
			$where .= $wh;
		}else{
			$where .= ' 1=1 ';
		}
		if(isset($_GET['count'])){
			$count = $_GET['count'];
		}
		//ͳ�Ʊ���ܼ�¼��,���count��ֵ�����ٴβ�ѯ��ȷ����ҳֻ��һ�β�ѯ
		if(!$count){
			$res = Database::instance()->query($sql.$where.' '.$group_by);
			$count = sizeof($res);
		}
		if(!$uri){
			$uri = BASE_URL.'/'.Request::current()->url();
		}
		$pages = $page_obj->getPages ( $count, $page_size, $page, $uri );
		$where .= ' '.$group_by .= $order  .= $pages ['where'];
		
		$res_info = array();
		
		$res_info ['data'] = DB::query($sql.$where)->execute();
		$res_info ['pages'] = $pages;
		return $res_info;
	}
	/**
	 * ���˵�NULLֵ
	 * @param Sting $v
	 * @return boolean
	 */
	public static function remove_null($v){
		if(is_null($v)){
			return FALSE;
		}
		return TRUE;
	}
}
