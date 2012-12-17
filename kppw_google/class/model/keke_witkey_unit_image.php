<?php defined ('IN_KEKE' ) or die ( 'Access Denied' );
	class Keke_witkey_unit_image  extends Model {
	    protected static $_data = array ();
	     function  __construct(){ 			 parent::__construct ( 'witkey_unit_image' );		 }	    
	    		public function getUnit_id(){			 return self::$_data ['unit_id']; 		}		public function getUnit_name(){			 return self::$_data ['unit_name']; 		}		public function getUnit_pic(){			 return self::$_data ['unit_pic']; 		}		public function getUnit_type(){			 return self::$_data ['unit_type']; 		}		public function getWhere(){			 return self::$_where; 		}
	    		public function setUnit_id($value){ 			 self::$_data ['unit_id'] = $value;			 return $this ; 		}		public function setUnit_name($value){ 			 self::$_data ['unit_name'] = $value;			 return $this ; 		}		public function setUnit_pic($value){ 			 self::$_data ['unit_pic'] = $value;			 return $this ; 		}		public function setUnit_type($value){ 			 self::$_data ['unit_type'] = $value;			 return $this ; 		}		public function setWhere($value){ 			 self::$_where = $value;			 return $this; 		}		public function setData($array){ 			self::$_data = array_filter($array); 			return $this; 		} 
	    /**		 * insert into  keke_witkey_unit_image  ,or add new record		 * @return int last_insert_id		 */		function create($return_last_id=1){		 $res = $this->_db->insert ( $this->_tablename, self::$_data, $return_last_id, $this->_replace ); 		 $this->reset(); 			 return $res; 		 } 
	    /**		 * update table keke_witkey_unit_image		 * @return int affected_rows		 */		function update() {				if ($this->getWhere()) { 					$res =  $this->_db->update ( $this->_tablename, self::$_data, $this->getWhere());				} elseif (isset ( self::$_data ['unit_id'] )) { 						self::$_where = array ('unit_id' => self::$_data ['unit_id'] );						unset(self::$_data['unit_id']);						$res = $this->_db->update ( $this->_tablename, self::$_data, $this->getWhere() );				}				$this->reset();				return $res;		}
	    /**		 * query table: keke_witkey_unit_image,if isset where return where record,else return all record		 * @return array 		 */		function query($fields = '*',$cache_time = 0){ 			 empty ( $fields ) and $fields = '*';			 if($this->getWhere()){ 				 $sql = "select $fields from $this->_tablename where ".$this->getWhere(); 			 }else{ 				 $sql = "select $fields from $this->_tablename"; 			 } 			 empty($fields) and $fields = '*'; 			 $this->reset();			 return $this->_db->cached ( $cache_time )->cache_data ( $sql );		 } 
	    /**		 * query count keke_witkey_unit_image records,if iset where query by where 		 * @return int count records		 */		function count(){ 			 if($this->getWhere()){ 				 $sql = "select count(*) as count from $this->_tablename where ".$this->getWhere(); 			 } 			 else{ 				 $sql = "select count(*) as count from $this->_tablename"; 			 } 			 $this->reset(); 			 return $this->_db->get_count ( $sql ); 		 } 
	    /**		 * delete table keke_witkey_unit_image, if isset where delete by where 		 * @return int deleted affected_rows 		 */		function del(){ 			 if($this->getWhere()){ 				 $sql = "delete from $this->_tablename where ".$this->getWhere(); 			 } 			 else{ 				 $sql = "delete from $this->_tablename where unit_id = $this->_unit_id "; 			 } 			 $this->reset(); 			 return $this->_db->query ( $sql, Database::DELETE ); 		 } 
   } //end 