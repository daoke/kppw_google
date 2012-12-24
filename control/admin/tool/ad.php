<?php defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );
/**
 * ��̨���λ����
 * 
 * @copyright keke-tech
 * @author ����
 * @version v 3.0
 *          @date 2012-12-24 ����09:58:43
 *          @encoding GBK
 */
class Control_admin_tool_ad extends Control_admin {
	/**
	 * ����б�
	 */
	function action_index() { 
		$fields = '`ad_id`,`target_id`,`ad_type`,`ad_name`,`ad_file`,`ad_content`,`ad_url`,`end_time`,`listorder`,`width`,`height`';		
		$query_fields = array (	'ad_id' => '���ID',	'ad_name' => '�������'); 
 	
		$base_uri = BASE_URL . "/index.php/admin/tool_ad";
		// ɾ��uri��del�ǹ̶���
		$del_uri = $base_uri . "/del";
		$add_uri = $base_uri . "/add";
		// �޸Ĺ��λ״̬��URI
		$change_uri = $base_uri . "/changestates";
		// ����Ҫ��ҳ��page_size���ô�
		$page_size = $_GET ['page_size'];
		
		$targets = DB::select('target_id,name')->from('witkey_ad_target')->cached(60000,'keke_adtarget_list')->execute();
		
		$targets = Arr::get_arr_by_key($targets, 'target_id');
		
		$this->_default_ord_field = 'ad_id';
		
		extract ( $this->get_url ( $base_uri ) );
		
	    //����û��Ǵӹ��λҳ����ת�����ģ���ָ����ѯ����
		if(isset($_GET['target_id'])){
			$target_id = $_GET['target_id'];
			$where .= " and target_id = {$_GET['target_id']}";
		}
		$data_info = Model::factory ( 'witkey_ad' )->get_grid ( $fields, $where, $uri, $order, $page, $count, $_GET ['page_size'] );
		// �б�����
		$ad_list = $data_info ['data'];
		
		// ��ҳ����
		$pages = $data_info ['pages'];
		
		require Keke_tpl::template ( 'control/admin/tpl/tool/ad_list' );
	}
	/**
	*��ӡ��޸Ĺ��
	*/
	function action_add() {
		$targets = DB::select('target_id,name')->from('witkey_ad_target')->execute();
		$target_id=$_GET['target_id'];
		$targets = Arr::get_arr_by_key($targets, 'target_id');
		$type = $_GET ['type'];
		$ad_id = $_GET ['ad_id'];
		// �����ֵ���ͽ���༭״̬
		$ad_info = DB::select ()->from ( 'witkey_ad' )->where ( "ad_id = '$ad_id'" )->get_one ()->execute ();
		
		require Keke_tpl::template ( 'control/admin/tpl/tool/ad_add' );
	}
 
	/**
	 * ��������Ϣ
	 */
	function action_save() {
		
		$_POST = Keke_tpl::chars ( $_POST );
		// ��ֹ�����ύ���㶮��
		Keke::formcheck ( $_POST ['formhash'] );
		// var_dump($_POST);die;
		$type = $_POST ['type'];
		// ������ô˵�أ���������sql ���ֶ�=>ֵ �����飬�㲻����������̫����.
		$array = array (
				'ad_type' => $_POST ['rad_ad_type'],
				'ad_name' => $_POST ['txt_ad_name'],
				'ad_url' => $_POST ['txt_ad_url'],
				'end_time' => strtotime($_POST ['txt_ad_end_time']),
				'listorder' => $_POST ['txt_ad_listorder'],
				'width' => $_POST ['txt_ad_width'],
				'height' => $_POST ['txt_ad_width'],
				'target_id' => $_POST['sel_target_id'],
				'ad_file'=>"",
				'ad_content'=>""
		);
		//�жϹ������
		switch ($array['ad_type']){
			case 'code':
				$array['ad_content']=$_POST['code_ad_content'];
				break;
			case 'text':
				$array['ad_content']=$_POST['txt_ad_content'];
				break;
			case 'image':
				$array['ad_file']=$_POST['hdn_img_ad_file'];
				break;
			case 'flash':
				if ($_POST['flash_method']=='url'){
					$array['ad_file']=$_POST['flaurl_ad_fil'];
				}elseif ($_POST['flash_method']=='file'){
					$array['ad_file']=$_POST['flafil_ad_fil'];
				}
				break;
		}
		
		Cache::instance()->del('keke_adtarget_list');
		
 		//����й��IDֵ����update���ݱ�
		if ($_POST ['hdn_ad_id']) {
			$ad_id = $_POST ['hdn_ad_id'];
			Model::factory ( 'witkey_ad' )->setData ( $array )->setWhere ( "ad_id = '{$_POST['hdn_ad_id']}'" )->update ();
			// ִ�����ˣ�Ҫ��һ����ʾ������û�ж�ִ�еĽ�����жϣ�����͵���������ִ��ʧ�ܵĻ����϶����ᱨ��ġ���!
			Keke::show_msg ( '�ύ�ɹ�', "admin/tool_ad/add?ad_id=$ad_id" );
		} else {
			// ��Ҳ��Ȼ�������(insert)�����ݿ���
			Model::factory ( 'witkey_ad' )->setData ( $array )->create ();
			$this->request->redirect ( 'admin/tool_ad' );
		}
	}
	/**
	 * ɾ�����
	 */
	function action_del() {
		$page = $_GET [page];
		$page_size = $_GET [page_size];
		
		// ɾ������,�����case_id ����ģ���ϵ������������е�
		if ($_GET ['ad_id']) {
			$where = 'ad_id = ' . $_GET ['ad_id'];
			// ɾ������,���������ͳһΪidsӴ����
		} elseif ($_GET ['ids']) {
			$where = 'ad_id in (' . $_GET ['ids'] . ')';
		}
	 
		echo Model::factory ( 'witkey_ad' )->setWhere ( $where )->del ();
	}
	/**
	 * ���ݹ��������ǰ̨��ʾ��Ӧ�Ĺ������
	 */
	function out($ad_info){
		switch ($ad_info['ad_type']){
			case'image':
				echo "<img width='50' height='25' src=".BASE_URL.'/'.$ad_info['ad_file'].">";
				break;
			case 'text':
				echo "<a href={$ad_info['ad_url']}>{$ad_info['ad_content']}</a>";
				break;
			case 'flash':
				echo keke_file_class::flash_codeout($ad_info['ad_file'],50,25);
				break;	
			case 'code':
				echo "$ad_info[ad_content]";
				break;	
		}
	}
	/**
	 * ajaxɾ��ADͼƬ
	 */
	static function action_del_img(){
		//���pk��ֵ����ɾ���ļ����е�art_pic
		if($_GET['pk']){
			Dbfactory::execute(" update ".TABLEPRE."witkey_ad set ad_file ='' where ad_id = ".intval($_GET['pk']));
		}
		//û��fid�Ͳ���fid,û��fid����ɾ���ļ�,���ڰ�ȫ����
		if(!intval($_GET['fid'])){
			$fid = Dbfactory::get_count(" select file_id from ".TABLEPRE."witkey_file where save_name = '.{$_GET['filepath']}.'");
		}else{
			$fid = $_GET['fid'];
		}
		//ɾ���ļ�
		keke_file_class::del_att_file($fid, $_GET['filepath']);
		Keke::echojson ( '', '1' );
	}
	/**
	 * ��ѯ���λʣ������
	 */
	function action_get_targetnum(){
		$target_id = intval($_GET['target_id']);
		$adtarget_info= DB::select ()->from ( 'witkey_ad_target' )->where ( "target_id = $target_id" )->get_one()->execute ();
		$ad_info=Dbfactory::query("select count(*) from ".TABLEPRE."witkey_ad where target_id = $target_id");
		$adtarget_num=$adtarget_info['ad_num']-$ad_info[0]['count(*)'];
		echo "$adtarget_num";
	}
}
	