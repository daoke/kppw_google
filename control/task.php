<?php  defined ( 'IN_KEKE' ) or exit ( 'Access Denied' );

/**
 * ������ϸҳ��������ҳ������ļ�
 * @copyright keke-tech
 * @author Michael
 * @version 3.0
 */

class Control_task extends Controller{
	function action_index(){
		
		$id = $this->request->param('id');
		var_dump($id);
		
		echo 1;
	}
}
 