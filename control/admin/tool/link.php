<?php defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * ��̨��������Ŀ�����
 * @author michael
 *
 */

class Control_admin_tool_link extends Control_admin {
	
	 
	function action_index() {
		 
		global $_lang;
		
		 
		$fields = ' `link_id`,`link_name`,`link_url`,`listorder`,`on_time` ';
		 
		$query_fields = array('link_id'=>$_lang['id'],'link_name'=>$_lang['name'],'on_time'=>$_lang['time']);
		 
		 
		$base_uri = BASE_URL."/index.php/admin/tool_link";
		
		 
		$add_uri =  $base_uri.'/add';
		 
		$del_uri = $base_uri.'/del';
		 
		$this->_default_ord_field = 'on_time';
		 
		extract($this->get_url($base_uri));
		 
		$data_info = Model::factory('witkey_link')->get_grid($fields,$where,$uri,$order);
		 
		$link_arr = $data_info['data'];
		 
		$pages = $data_info['pages']['page'];
 		
		require Keke_tpl::template('control/admin/tpl/tool/link');
	}
	
	//�����༭��ʼ��
	function action_add(){
		
		
		if(isset($_GET['link_id'])){
			$link_id = $_GET['link_id'];
			$link_info = DB::select()->from('witkey_link')->where("link_id = '$link_id'")->get_one()->execute();
		}
		$link_pic = $link_info['link_pic'];
		if(strpos($link_pic, 'http')!==FALSE){
			$mode = 1;
		}else{
			$mode = 2;
		}
		
		require Keke_tpl::template('control/admin/tpl/tool/link_add');
	}
	/**
	 * ����ģ�����ύ�������ݵ����ݿ���
	 * ���acton ��ͨ�õģ���Ҫ��㶨���������
	 * 
	 */
	function action_save(){
		$_POST = Keke_tpl::chars($_POST);
		
		Keke::formcheck($_POST['formhash']);
		
		if($_POST['showMode'] ==1){
			$link_pic = $_POST['txt_link_pic'];
		}elseif(!empty($_FILES['fle_link_pic']['name'])){
			
			$link_pic = File::upload_file('fle_link_pic');
		}
		$arr = array('link_name'=>$_POST['txt_link_name'],
				     'link_url'=>$_POST['txt_link_url'],
					 'link_pic'=>$link_pic,
					 'listorder' => $_POST['txt_listorder'],
				     'on_time'=>time(),				  
		);
       if($_POST['hdn_link_id']){
			$where = "link_id ='{$_POST['hdn_link_id']}'";
			DB::update('witkey_link')->set(array_keys($arr))->value(array_values($arr))->where($where)->execute();
			$this->request->redirect('admin/tool_link/add?link_id='.$_POST['hdn_link_id']);
		}else{
		 	DB::insert('witkey_link')->set(array_keys($arr))->value(array_values($arr))->execute();
			$this->request->redirect('admin/tool_link/add');
		}
	}
	/**
	 * ������ɾ����action ��Ҫ�Ǵ���Ҫ����ɾ��
	 * �����ɾ����
	 * ��أ�ɾ��action������ͳһdel,��Ҫ��Ϊʲô
	 * ����ɾ����������������ֵ�Ϳ���ɾ����
	 * ����ɾ���ģ���ǰ��jsƴ�Ӻõ�ids��������ֵ.js ֻ��ids ��Ӵ����Ҫд����������
	 * 
	 */
	function action_del(){
		if(isset($_GET['link_id'])){  
			$where = "link_id = '{$_GET['link_id']}'";
		}elseif(isset($_GET['ids'])){
			$where = "link_id in ('{$_GET['ids']}')";
		}
		echo DB::delete('witkey_link')->where($where)->execute();
	}
	
}
