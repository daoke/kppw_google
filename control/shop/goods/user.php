<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �û����������б���༭
 * @author Michael
 * @version 3.0
   2012-10-19
 */

class Control_shop_goods_user extends Control_user{
    
	
	/**
	 * @var һ���˵�ѡ����
	 */
	protected static $_default = 'seller';
	/**
	 * @var �����˵�ѡ����,��ֵ����ѡ��
	 */
	protected static $_left = 'goods';
	
 	/**
	 * �������Ʒ������Ϣ
	 */
  	function action_buyer(){
  		self::$_default = 'buyer';
		Control_user_buyer_index::init_nav();
	
		require Keke_tpl::template('control/shop/goods/tpl/user/buyer');
	}  
	
 	/**
	 * ����������Ʒ����
	 */
	function action_seller(){
		self::$_left = 'goodsorder';	
		

		Control_user_seller_index::init_nav();
		
		$query_fields = array('a.order_id'=>'������','a.order_name'=>'������');
		
		$base_uri = PHP_URL."/shop/goods_user/seller";
		$sql="select a.order_id,a.order_name,a.order_time,a.order_amount,a.order_status,
			 a.order_body,a.order_uid,a.order_username,a.seller_uid,a.seller_username,\n".
			 "b.detail_id,b.obj_type,b.obj_id,b.price,b.num,b.model_id,\n".
			 " c.mobile,c.qq\n".
			 "from keke_witkey_order a\n".
			 "left join keke_witkey_order_detail b\n".
			 "on a.order_id=b.order_id and b.model_id=6\n".
			 "left join :keke_witkey_space c\n".
			 "on a.order_uid=c.uid\n";		

		$order_ststus=Sys_order::task_order_status();
		
		$sql = DB::query($sql)->tablepre(':keke_')->compile(Database::instance());
				
		$base_uri = PHP_URL."/shop/goods_user/seller";
		$open_url = PHP_URL."/shop/goods_user/comment";
		extract ( $this->get_url ( $base_uri ) );
		
		$where .= " and a.seller_uid=$this->uid";
		if($_GET['status']){
			$status=$_GET['status'];
			$where .=" and a.order_status= '$status'";
		}
		$this->_default_ord_field = 'a.order_id';
		$this->_uri = $uri;
		
		$data =Model::sql_grid($sql,$where,$uri,$order);
		$order_arr=$data['data'];
		require Keke_tpl::template('control/shop/goods/tpl/user/seller');
	}
	
	
	/**
	 * ��������Ʒ�б�
	 */
	function action_pub(){
		 self::$_left = 'goodspub';
		 Control_user_seller_index::init_nav();
		 $fields = '`sid`,`pic`,`title`,`price`,`unite_price`,`sale_num`,`status`,`on_time`';
		 $query_fields = array('sid'=>'��ƷID','title'=>'��Ʒ����');
		 $base_uri = PHP_URL."/shop/goods_user/pub";
		 extract ( $this->get_url ( $base_uri ) );
		 $where .= " and uid='$this->uid'";
		 if($_GET['status']){
		 	$status=$_GET['status'];
			$where .="and status =$status";
		 }
		 $data_info = Model::factory('witkey_service')->get_grid( $fields, $where, $uri, $order);
		 $list_arr = $data_info['data'];
		 $pages = $data_info['pages'];
		require Keke_tpl::template('control/shop/goods/tpl/user/pub');
	}
	/**
	 * ���¼���Ʒ
	 */
	function action_change_status(){
		$sid=(int)$_GET['sid'];
		$status=(int)$_GET['status']==1?2:1;
		DB::update('witkey_service')->set(array('status'))->value(array($status))->where("sid='$sid'")->execute();
		$this->request->redirect ( "shop/goods_user/pub?status=$status" );
	}
	/**
	 * ɾ����Ʒ
	 */
	function action_del(){
		DB::delete('witkey_service')->where("sid='{$_GET['sid']}'")->execute();
	}
	/**
	 * ��Ʒ�༭ 
	 */
	function action_edit(){
		self::$_left = 'goodspub';
		Control_user_seller_index::init_nav();
		$sid=$_GET['sid'];
		$sql="select a.sid,a.model_id,a.indus_id,a.title,a.price,a.service_time,a.unit_time,a.content,\n".
			 "GROUP_CONCAT(conv(oct(b.file_id),8,10)) file_id,GROUP_CONCAT(b.file_name) file_name,GROUP_CONCAT(b.save_name) save_name\n".
			 "from	:keke_witkey_service a\n".
			 "LEFT JOIN	:keke_witkey_file b\n".
			 "on a.sid = b.obj_id\n".
			 "WHERE a.sid=:sid";
		$service_info = DB::query($sql)->tablepre(':keke_')->param(':sid', $sid)->get_one()->execute();
		
		$file_info =array_map(NULL,explode(',',$service_info['save_name']),
				explode(',', $service_info['file_name']),
				explode(',', $service_info['file_id']));
		if($file_info[0][0]){
			$length = 5-sizeof($file_info);
		}else{
			$length = 5;
		}
		$ext =  "*.jpg;*.gif;*.bmp;*.png";
		$indus_arr = Sys_indus::get_indus_tree($service_info['indus_id']);
		require Keke_tpl::template('control/shop/goods/tpl/user/pub_edit');
	}
	/**
	 * ��Ʒ����
	 */
	function action_save(){
		
		Keke::formcheck ( $_POST ['formhash'] );
		$_POST = Keke_tpl::chars ( $_POST );
	
		$array=array(
				'model_id'=>$_POST['rad_type'],
				'indus_id'=>$_POST['sel_indus_id'],
				'title'=>$_POST['txt_title'],
				'content'=>$_POST['txa_content'],
				'price'=>$_POST['txt_price'],
				'service_time'=>$_POST['txt_service_time'],
				'unit_time'=>$_POST['sel_unit_time'],
		);
		$sid = $_POST ['hdn_sid'];

		Model::factory ( 'witkey_service' )->setData ( $array )->setWhere ( "sid = '$sid'" )->update ();
		
		$this->request->redirect ( "shop/goods_user/edit?sid=$sid" );
	}
	/**
	 * ɾ����Ʒ����
	 */
	function action_del_file(){
		File::del_att_file($_GET['fid'],$_GET['file_path']);
	}
	
	/**
	 *��˽��
	 */
	function action_comment(){
		$buyer_name=$_GET['to_send'];
		$uri='shop/goods_user/seller';
		require Keke_tpl::template('control/shop/goods/tpl/user/msg');
	}
	/**
	 * ��˽��
	 */
 	function action_send(){
 		Keke_msg::instance()->send_msg($_POST['txt_to_username'],$_POST['txt_title'],$_POST['txt_content']);
 		$this->request->redirect ( "shop/goods_user/seller");
 	}
	
}