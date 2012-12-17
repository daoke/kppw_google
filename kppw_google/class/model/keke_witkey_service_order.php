<?php defined ('IN_KEKE' ) or die ( 'Access Denied' );
	class Keke_witkey_service_order  extends Model {
	    protected static $_data = array ();
	     function  __construct(){ 			 parent::__construct ( 'witkey_service_order' );		 }	    
	    		public function getOrder_id(){			 return self::$_data ['order_id']; 		}		public function getModel_id(){			 return self::$_data ['model_id']; 		}		public function getSale_uid(){			 return self::$_data ['sale_uid']; 		}		public function getSale_username(){			 return self::$_data ['sale_username']; 		}		public function getService_id(){			 return self::$_data ['service_id']; 		}		public function getService_type(){			 return self::$_data ['service_type']; 		}		public function getOn_time(){			 return self::$_data ['on_time']; 		}		public function getCount_cash(){			 return self::$_data ['count_cash']; 		}		public function getPay_cash(){			 return self::$_data ['pay_cash']; 		}		public function getClr_cash(){			 return self::$_data ['clr_cash']; 		}		public function getTitle(){			 return self::$_data ['title']; 		}		public function getSale_status(){			 return self::$_data ['sale_status']; 		}		public function getBuyer_status(){			 return self::$_data ['buyer_status']; 		}		public function getOrder_status(){			 return self::$_data ['order_status']; 		}		public function getBuy_username(){			 return self::$_data ['buy_username']; 		}		public function getBuy_uid(){			 return self::$_data ['buy_uid']; 		}		public function getCost_cash(){			 return self::$_data ['cost_cash']; 		}		public function getCost_credit(){			 return self::$_data ['cost_credit']; 		}		public function getOrder_num(){			 return self::$_data ['order_num']; 		}		public function getWhere(){			 return self::$_where; 		}
	    		public function setOrder_id($value){ 			 self::$_data ['order_id'] = $value;			 return $this ; 		}		public function setModel_id($value){ 			 self::$_data ['model_id'] = $value;			 return $this ; 		}		public function setSale_uid($value){ 			 self::$_data ['sale_uid'] = $value;			 return $this ; 		}		public function setSale_username($value){ 			 self::$_data ['sale_username'] = $value;			 return $this ; 		}		public function setService_id($value){ 			 self::$_data ['service_id'] = $value;			 return $this ; 		}		public function setService_type($value){ 			 self::$_data ['service_type'] = $value;			 return $this ; 		}		public function setOn_time($value){ 			 self::$_data ['on_time'] = $value;			 return $this ; 		}		public function setCount_cash($value){ 			 self::$_data ['count_cash'] = $value;			 return $this ; 		}		public function setPay_cash($value){ 			 self::$_data ['pay_cash'] = $value;			 return $this ; 		}		public function setClr_cash($value){ 			 self::$_data ['clr_cash'] = $value;			 return $this ; 		}		public function setTitle($value){ 			 self::$_data ['title'] = $value;			 return $this ; 		}		public function setSale_status($value){ 			 self::$_data ['sale_status'] = $value;			 return $this ; 		}		public function setBuyer_status($value){ 			 self::$_data ['buyer_status'] = $value;			 return $this ; 		}		public function setOrder_status($value){ 			 self::$_data ['order_status'] = $value;			 return $this ; 		}		public function setBuy_username($value){ 			 self::$_data ['buy_username'] = $value;			 return $this ; 		}		public function setBuy_uid($value){ 			 self::$_data ['buy_uid'] = $value;			 return $this ; 		}		public function setCost_cash($value){ 			 self::$_data ['cost_cash'] = $value;			 return $this ; 		}		public function setCost_credit($value){ 			 self::$_data ['cost_credit'] = $value;			 return $this ; 		}		public function setOrder_num($value){ 			 self::$_data ['order_num'] = $value;			 return $this ; 		}		public function setWhere($value){ 			 self::$_where = $value;			 return $this; 		}		public function setData($array){ 			self::$_data = array_filter($array); 			return $this; 		} 
	    /**		 * insert into  keke_witkey_service_order  ,or add new record		 * @return int last_insert_id		 */		function create($return_last_id=1){		 $res = $this->_db->insert ( $this->_tablename, self::$_data, $return_last_id, $this->_replace ); 		 $this->reset(); 			 return $res; 		 } 
	    /**		 * update table keke_witkey_service_order		 * @return int affected_rows		 */		function update() {				if ($this->getWhere()) { 					$res =  $this->_db->update ( $this->_tablename, self::$_data, $this->getWhere());				} elseif (isset ( self::$_data ['order_id'] )) { 						self::$_where = array ('order_id' => self::$_data ['order_id'] );						unset(self::$_data['order_id']);						$res = $this->_db->update ( $this->_tablename, self::$_data, $this->getWhere() );				}				$this->reset();				return $res;		}
	    /**		 * query table: keke_witkey_service_order,if isset where return where record,else return all record		 * @return array 		 */		function query($fields = '*',$cache_time = 0){ 			 empty ( $fields ) and $fields = '*';			 if($this->getWhere()){ 				 $sql = "select $fields from $this->_tablename where ".$this->getWhere(); 			 }else{ 				 $sql = "select $fields from $this->_tablename"; 			 } 			 empty($fields) and $fields = '*'; 			 $this->reset();			 return $this->_db->cached ( $cache_time )->cache_data ( $sql );		 } 
	    /**		 * query count keke_witkey_service_order records,if iset where query by where 		 * @return int count records		 */		function count(){ 			 if($this->getWhere()){ 				 $sql = "select count(*) as count from $this->_tablename where ".$this->getWhere(); 			 } 			 else{ 				 $sql = "select count(*) as count from $this->_tablename"; 			 } 			 $this->reset(); 			 return $this->_db->get_count ( $sql ); 		 } 
	    /**		 * delete table keke_witkey_service_order, if isset where delete by where 		 * @return int deleted affected_rows 		 */		function del(){ 			 if($this->getWhere()){ 				 $sql = "delete from $this->_tablename where ".$this->getWhere(); 			 } 			 else{ 				 $sql = "delete from $this->_tablename where order_id = $this->_order_id "; 			 } 			 $this->reset(); 			 return $this->_db->query ( $sql, Database::DELETE ); 		 } 
   } //end 