<?php defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * ���񸸿�����
 * @author Michael
 * @version 2.2 2012-12-20
 *
 */
class Control_task_task extends Controller {
    
	/**
	 * @var ��ʱ����ID
	 */
	private $_tmp_task_id = NULL;
	/**
	 * @var ��ʱ������Ϣ 
	 */
	protected  $_task_info = array();
	/**
	 * ������ʱ����ID
	 * @param int $id
	 */
	function set_tmp_task_id($id){
		$this->_tmp_task_id = $id;
		Cookie::set('tmp_task_id', $id);
	}
	/**
	 * ��ȡ��ʱ����ID
	 * @return int $id;
	 */
	function get_tmp_task_id(){
		if($this->_tmp_task_id){
			return $this->_tmp_task_id;
		}
		return Cookie::get('tmp_task_id');
	}
	
}
