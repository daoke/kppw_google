<?php defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
 /** 
 * @copyright keke-tech 
 * @author Michaeltsui98 
 * @version 3.0 2013-1-11 13:31:51 
 */
class Control_admin_tool_links extends Control_admin{
	function action_index() {
		$fidlds='`link_id`,`link_type`,`link_name`,`link_url`,`link_pic`,`listorder`,`link_status`,`on_time`,`obj_type`,`obj_id`';
		$query_fields = array('link_id'=>'����ID','link_type'=>'��������','link_name'=>'��������','link_url'=>'���ӵ�ַ','link_pic'=>'����ͼƬ','listorder'=>'����','link_status'=>'״̬','on_time'=>'ʱ��','obj_type'=>'��������','obj_id'=>'����ID');
		$base_uri = BASE_URL."/index.php/admin/tool_links";		$add_uri =  $base_uri.'/add';
		$del_uri = $base_uri.'/del';
		$this->_default_ord_field = 'link_id';		extract($this->get_url($base_uri));
		$data_info = Model::factory('witkey_link')->get_grid($fields,$where,$uri,$order);		$list_arr = $data_info['data'];
		$pages = $data_info['pages']['page'];
		require Keke_tpl::template('control/admin/tpl/tool/links');	}
	function action_add(){
		if(isset($_GET['link_id'])){
			$link_id = $_GET['link_id'];			$info = DB::select()->from('witkey_link')->where("link_id = '$link_id'")->get_one()->execute();		}
		require Keke_tpl::template('control/admin/tpl/tool/links_add');	}
	function action_save(){
		$_POST = Keke_tpl::chars($_POST);
		Keke::formcheck($_POST['formhash']);
		$arr = array('link_id'=>$_POST['txt_link_id'],					'link_type'=>$_POST['txt_link_type'],					'link_name'=>$_POST['txt_link_name'],					'link_url'=>$_POST['txt_link_url'],					'link_pic'=>$_POST['txt_link_pic'],					'listorder'=>$_POST['txt_listorder'],					'link_status'=>$_POST['txt_link_status'],					'on_time'=>$_POST['txt_on_time'],					'obj_type'=>$_POST['txt_obj_type'],					'obj_id'=>$_POST['txt_obj_id']);
		if($_POST['hdn_link_id']){
			$where = "link_id ='{$_POST['hdn_link_id']}'";
			DB::update('witkey_link')->set(array_keys($arr))->value(array_values($arr))->where($where)->execute();
			$this->request->redirect('admin/tool_links/add?link_id='.$_POST['hdn_link_id']);
		}else{
			DB::insert('witkey_link')->set(array_keys($arr))->value(array_values($arr))->execute();
			$this->request->redirect('admin/tool_links/add');
		}
	}
	function action_del(){
		if(isset($_GET['link_id'])){ 
			$where = "link_id = '{$_GET['link_id']}'";
		}elseif(isset($_GET['ids'])){
			$where = "link_id in ('{$_GET['ids']}')"; 
		}
		echo DB::delete('witkey_link')->where($where)->execute();
	}
}
