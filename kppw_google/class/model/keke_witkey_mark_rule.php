<?php defined ('IN_KEKE' ) or die ( 'Access Denied' );
	class Keke_witkey_mark_rule  extends Model {
	    protected static $_data = array ();
	     function  __construct(){ 			 parent::__construct ( 'witkey_mark_rule' );		 }	    
	    		public function getMark_rule_id(){			 return self::$_data ['mark_rule_id']; 		}		public function getG_value(){			 return self::$_data ['g_value']; 		}		public function getM_value(){			 return self::$_data ['m_value']; 		}		public function getG_title(){			 return self::$_data ['g_title']; 		}		public function getM_title(){			 return self::$_data ['m_title']; 		}		public function getG_ico(){			 return self::$_data ['g_ico']; 		}		public function getM_ico(){			 return self::$_data ['m_ico']; 		}		public function getWhere(){			 return self::$_where; 		}
	    		public function setMark_rule_id($value){ 			 self::$_data ['mark_rule_id'] = $value;			 return $this ; 		}		public function setG_value($value){ 			 self::$_data ['g_value'] = $value;			 return $this ; 		}		public function setM_value($value){ 			 self::$_data ['m_value'] = $value;			 return $this ; 		}		public function setG_title($value){ 			 self::$_data ['g_title'] = $value;			 return $this ; 		}		public function setM_title($value){ 			 self::$_data ['m_title'] = $value;			 return $this ; 		}		public function setG_ico($value){ 			 self::$_data ['g_ico'] = $value;			 return $this ; 		}		public function setM_ico($value){ 			 self::$_data ['m_ico'] = $value;			 return $this ; 		}		public function setWhere($value){ 			 self::$_where = $value;			 return $this; 		}		public function setData($array){ 			self::$_data = array_filter($array,array('Model','remove_null')); 			return $this; 		} 
	    /**		 * insert into  keke_witkey_mark_rule  ,or add new record		 * @return int last_insert_id		 */		function create($return_last_id=1){		 $res = $this->_db->insert ( $this->_tablename, self::$_data, $return_last_id, $this->_replace ); 		 $this->reset(); 			 return $res; 		 } 
	    /**		 * update table keke_witkey_mark_rule		 * @return int affected_rows		 */		function update() {				if ($this->getWhere()) { 					$res =  $this->_db->update ( $this->_tablename, self::$_data, $this->getWhere());				} elseif (isset ( self::$_data ['mark_rule_id'] )) { 						self::$_where = array ('mark_rule_id' => self::$_data ['mark_rule_id'] );						unset(self::$_data['mark_rule_id']);						$res = $this->_db->update ( $this->_tablename, self::$_data, $this->getWhere() );				}				$this->reset();				return $res;		}
	    /**		 * query table: keke_witkey_mark_rule,if isset where return where record,else return all record		 * @return array 		 */		function query($fields = '*',$cache_time = 0){ 			 empty ( $fields ) and $fields = '*';			 if($this->getWhere()){ 				 $sql = "select $fields from $this->_tablename where ".$this->getWhere(); 			 }else{ 				 $sql = "select $fields from $this->_tablename"; 			 } 			 empty($fields) and $fields = '*'; 			 $this->reset();			 return $this->_db->cached ( $cache_time )->cache_data ( $sql );		 } 
	    /**		 * query count keke_witkey_mark_rule records,if iset where query by where 		 * @return int count records		 */		function count(){ 			 if($this->getWhere()){ 				 $sql = "select count(*) as count from $this->_tablename where ".$this->getWhere(); 			 } 			 else{ 				 $sql = "select count(*) as count from $this->_tablename"; 			 } 			 $this->reset(); 			 return $this->_db->get_count ( $sql ); 		 } 
	    /**		 * delete table keke_witkey_mark_rule, if isset where delete by where 		 * @return int deleted affected_rows 		 */		function del(){ 			 if($this->getWhere()){ 				 $sql = "delete from $this->_tablename where ".$this->getWhere(); 			 } 			 else{ 				 $sql = "delete from $this->_tablename where mark_rule_id = $this->_mark_rule_id "; 			 } 			 $this->reset(); 			 return $this->_db->query ( $sql, Database::DELETE ); 		 } 
   } //end 