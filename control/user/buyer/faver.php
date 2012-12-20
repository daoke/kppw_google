<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �û�����-���-�������Ʒ
 * @author Michael
 * @version 2.2
   2012-10-19
 */

class Control_user_buyer_faver extends Control_user{
    
	
	/**
	 * @var һ���˵�ѡ����
	 */
	protected static $_default = 'buyer';
	/**
	 *
	 * @var �����˵�ѡ����,��ֵ����ѡ��
	 */
	protected static $_left = 'faver';
	
	/**
	 * ����
	 */
	function action_index(){
		
		$query_fields = array ('a.origin_id' => '��ƷID', 'c.title' => '��Ʒ����');
		
		$data = $this->favor_service();
		
		$uri = $this->_uri;
		
		$ord_tag = $this->_ord_tag;
		
		$ord_char = $this->_ord_char;
		
		$list_arr = $data ['data'];
		 
		$pages = $data ['pages'];
		
		require Keke_tpl::template('user/buyer/faver_goods');
	}
	
	
	
	function action_task(){
		 
		$query_fields = array ('a.origin_id' => '����ID', 'c.task_title' => '��������');
		
		$data = $this->favor_task();
		
		$uri = $this->_uri;
		
		$ord_tag = $this->_ord_tag;
		
		$ord_char = $this->_ord_char;
		
		$list_arr = $data ['data'];
		
		
		$pages = $data ['pages'];
		
		require Keke_tpl::template('user/buyer/faver_task');
	}
	
	
	/**
	 *	�û��ղ���Ʒ����
	 * @return array
	 */
	function favor_service(){
		$sql = "SELECT a.fid,a.origin_id, b.model_code,b.model_id,\n".
				"c.title,c.price,c.unite_price,c.pic \n".
				"FROM `:keke_witkey_favorite` a \n".
				"left JOIN :keke_witkey_model b \n".
				"on a.obj_type = b.model_code and b.model_type = 'shop'\n".
				"left join :keke_witkey_service c \n".
				"on b.model_id = c.model_id and c.sid = a.origin_id\n";
	
		$sql = DB::query($sql)->tablepre(':keke_')->compile(Database::instance());
	
		
		$this->_default_ord_field = 'a.fid';
	
		$base_uri = PHP_URL . "/user/buyer_faver";
	
		extract ( $this->get_url ( $base_uri ) );
	
		$where .= "  and a.uid = $this->uid ";
			
		$this->_uri = $uri;
		$this->_ord_tag = $ord_tag;
		$this->_ord_char = $ord_char;
		var_dump($sql,$where);
		return (array)Model::sql_grid($sql,$where,$uri,$order,$group);
	}
	/**
	 *�û��ղ���������
	 * @return array
	 */
	function favor_task(){
		$sql = "SELECT a.fid,a.origin_id, b.model_code,\n".
				"c.task_title ,c.task_status,\n".
				"c.task_cash \n".
				"FROM `:keke_witkey_favorite` a \n".
				"left JOIN :keke_witkey_model b \n".
				"on a.obj_type = b.model_code\n".
				"left join :keke_witkey_task c \n".
				"on b.model_id = c.model_id and b.model_type = 'task'\n";
	
		$sql = DB::query($sql)->tablepre(':keke_')->compile(Database::instance());
	
		$this->_default_ord_field = 'a.fid';
	
		$base_uri = PHP_URL . "/user/buyer_faver/task";
	
		extract ( $this->get_url ( $base_uri ) );
	
		$where .= " and  b.model_type='task' and a.uid = $this->uid ";
			
		$this->_uri = $uri;
		$this->_ord_tag = $ord_tag;
		$this->_ord_char = $ord_char;
	
		return (array)Model::sql_grid($sql,$where,$uri,$order,$group);
	}
	
}