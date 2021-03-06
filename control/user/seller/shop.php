<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * 用户中心-服务商-店铺管理
 * @author 刀客
 * @version 3.0
   2012-12-26
 */

class Control_user_seller_shop extends Control_user{
    
	/**
	 * @var 一级菜单选中项
	 */
	protected static $_default = 'seller';
    /**
     * 
     * @var 二级菜单选中项,空值不做选择
     */
	protected static $_left = 'shop';
	
	function before(){
		parent::before();
		Control_user_seller_index::init_nav();
	}
	/**
	 * 店铺开通，店铺设置
	 */
	function action_index(){
		global $_K,$_lang;
		//是否认证
		$case_uri= USER_URL ."/seller_shop/case";
		$member_uri=USER_URL."/seller_shop/member";
					
		$is_auth = $this->get_is_auth();

		$shop_arr = DB::select()->from('witkey_shop')->where('uid = '.$_SESSION['uid'])->get_one()->execute();		
		
		require Keke_tpl::template('user/seller/shop');
	}
	/**
	 * 案例列表
	 */
	function action_case(){
		$case_add_uri=USER_URL."/seller_shop/case_add";
		$case_del_uri=USER_URL."/seller_shop/case_del";
		$fields='`case_id`,`cate_id`,`shop_id`,`indus_id`,`case_type`,`service_id`,`case_name`,`case_desc`,`case_pic`,`case_url`,`start_time`,`end_time`,`on_time`';
		
		$query_fields = array (	'case_id' => '店铺ID',	'case_name' => '店铺名称');
		$this->_default_ord_field='case_id';
		
		$base_uri = USER_URL.'/seller_shop/case';
		
		extract ( $this->get_url ( $base_uri ) );
		
		$data_info = Model::factory ( 'witkey_shop_case' )->get_grid ( $fields, $where, $uri, $order, $page, $count, $_GET ['page_size'] );
		
		$shop_case_list=$data_info['data'];

		$pages=$data_info['pages'];

		require Keke_tpl::template('user/seller/shop_case');
	}
	/**
	 * 案例编辑，添加
	 */
	function action_case_add(){
		$case_save_uri=USER_URL."/seller_shop/case_save";
		$case_id = $_GET ['case_id'];
		$case_info = DB::select ()->from ( 'witkey_shop_case' )->where ( "case_id = '$case_id'" )->get_one ()->execute ();
		
		$shop_arr= DB::select ('shop_id')->from ( 'witkey_shop' )->where ( "uid = '$this->uid'" )->get_one ()->execute ();

		$indus_arr = Sys_indus::get_indus_tree($case_info['indus_id']);

		$service_arr = DB::select('sid,title')->from('witkey_service')->where("uid = $this->uid")->execute();	
		
		require Keke_tpl::template('user/seller/shop_case_add');
	}
	/**
	 * 案例数据保存
	 */
	function action_case_save(){
		Keke::formcheck ( $_POST ['formhash'] );
		$_POST = Keke_tpl::chars ( $_POST );
			
		$type = $_POST ['type'];
		$array=array(
				'indus_id'=>$_POST['sel_indus'],
				'case_type'=>$_POST['rad_casetype'],
				'case_desc'=>$_POST['txa_desc'],
				'case_url'=>$_POST['txt_url'],
				'shop_id'=>$_POST['hdn_shop_id'],
				'case_pic'=>File::upload_file('fil_pic','jpg|gif|png|jpeg'),
				);
		$arr=explode('@#',$_POST['sel_service']);
		$array['service_id']=$arr[0];
		$array['case_name']=$arr[1];

		
		if($_POST ['hdn_case_id']) {
			$case_id = $_POST ['hdn_case_id'];
			Model::factory ( 'witkey_shop_case' )->setData ( $array )->setWhere ( "case_id = '{$_POST['hdn_case_id']}'" )->update ();
			$this->request->redirect ( "/user/seller_shop/case_add?case_id=$case_id" );
		} else {
			Model::factory ( 'witkey_shop_case' )->setData ( $array )->create ();
			$this->request->redirect ( '/user/seller_shop/case' );
		}
	}
	/**
	 * 案例数据删除
	 */
	function action_case_del(){
		if(isset($_GET['case_id'])){
			$where = 'case_id='.$_GET['case_id'];
		}
		DB::delete('witkey_shop_case')->where($where)->execute();
	}
	/**
	 * 成员列表                                                                                  
	 */
	function action_member(){
		$member_add_uri=USER_URL."/seller_shop/member_add";
		$member_del_uri=USER_URL."/seller_shop/member_del";
		$fields='`member_id`,`shop_id`,`truename`,`member_pic`,`member_job`,`entry_age`,`top_eduction`,`school`,`member_desc`';
		$query_fields = array (	'member_id' => '成员ID',	'truename' => '成员名称');
		
		$this->_default_ord_field='member_id';
		
		$base_uri = USER_URL.'/seller_shop/member';
		
		extract ( $this->get_url ( $base_uri ) );
		
		$data_info = Model::factory ( 'witkey_shop_member' )->get_grid ( $fields, $where, $uri, $order, $page, $count, $_GET ['page_size'] );
		
		$shop_member_list=$data_info['data'];
		
		$pages=$data_info['pages'];
		require Keke_tpl::template('user/seller/shop_member');
	}
	/**
	 * 成员编辑添加
	 */
	function action_member_add(){
		$member_save_uri=USER_URL."/seller_shop/member_save";
		$member_id = $_GET ['member_id'];
		$shop_arr= DB::select ('shop_id')->from ( 'witkey_shop' )->where ( "uid = '$this->uid'" )->get_one ()->execute ();
		$member_info = DB::select ()->from ( 'witkey_shop_member' )->where ( "member_id = '$member_id'" )->get_one ()->execute ();
		//获取职位名称
		$inc_job=Control_user_account_detail::$inc_job;
		//获取年份
		$year = Date::get_year();
		list($s_year,$n_year) = explode(',', $member_info['entry_age']);
		$eduction=array('博士','硕士','本科','大专','高中','初中','小学');
		require Keke_tpl::template('user/seller/shop_member_add');
	}
	/**
	 * 成员数据保存
	 */
	function action_member_save(){
		Keke::formcheck($_POST['formhash']);
		$_POST = Keke_tpl::chars ( $_POST );
		$array=array(
				'shop_id'=>$_POST['hdn_shop_id'],
				'truename'=>$_POST['txt_truename'],
				'member_pic'=>File::upload_file('fil_member_pic','jpg|gif|png|jpeg'),
				'member_job'=>$_POST['sel_member_job'],
				'member_desc'=>$_POST['txa_member_desc'],
				'top_eduction'=>$_POST['sel_top_eduction'],
				'school'=>$_POST['txt_school'],				
				);
		$array['entry_age']=$_POST['sel_left_entry_age'].",".$_POST['sel_right_entry_age'];

		if($_POST ['hdn_member_id']) {
			$member_id=$_POST ['hdn_member_id'];
			Model::factory ( 'witkey_shop_member' )->setData ( $array )->setWhere ( "member_id = '$member_id'" )->update ();
			$this->request->redirect ( "/user/seller_shop/member_add?member_id=$member_id" );
		} else {
			Model::factory ( 'witkey_shop_member' )->setData ( $array )->create ();
			$this->request->redirect ( '/user/seller_shop/member' );
		}
	}
	/**
	 *  成员数据删除
	 */
	function action_member_del(){
		if(isset($_GET['member_id'])){
			$where = 'member_id='.$_GET['member_id'];
		}
		DB::delete('witkey_shop_member')->where($where)->execute();
	}
	/**
	 *  店铺数据保存 
	 */
	function action_save(){
		$_POST = Keke_tpl::chars($_POST);
		$arr = array('shop_name'=>$_POST['shop_name'],'shop_desc'=>$_POST['shop_desc'],
				'uid'=>$this->uid,'username'=>$this->username,'shop_type'=>$this->group_id==3?2:1
				);
		if($_POST['hdn_shop_id']){
			DB::update('witkey_shop')->set(array_keys($arr))->value(array_values($arr))->where("shop_id = '{$_POST['hdn_shop_id']}'")->execute();
		}else{
			DB::insert('witkey_shop')->set(array_keys($arr))->value(array_values($arr))->execute();
		}
		Keke::show_msg('提交成功','user/seller_shop');
	}
	
	/**
	 * 判断是否通过认证
	 * @return 
	 */
	function get_is_auth(){
		$info = DB::select()->from('witkey_member_auth')->where("uid = ".$_SESSION['uid'])->get_one()->execute();
		
		if($this->group_id==3){
			return (bool)$info['enterprise'];
		}else{
			return (bool)$info['realname'];
		}
	}
	
	
}