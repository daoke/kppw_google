<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �û����������б���༭
 * @author Michael
 * @version 3.0
   2012-10-19
 */

class Control_task_sreward_user extends Control_user{
    
	
	/**
	 * @var һ���˵�ѡ����
	 */
	protected static $_default = 'buyer';
	/**
	 * @var �����˵�ѡ����,��ֵ����ѡ��
	 */
	protected static $_left = 'sreward';
	
	/**
	 * �ҷ���������
	 */
	function action_index(){
		
		require Keke_tpl::template('control/task/sreward/tpl/user/task_list');
	}
	/**
	 * ����������༭  
	 */
	function action_edit(){
		
		require Keke_tpl::template('control/task/sreward/tpl/user/task_edit');
	}
	/**
	 * �Ҳ��������
	 */
	function action_seller(){
		self::$_default = 'seller';
		self::$_left = 'sreward';
		
		
		require Keke_tpl::template('control/task/sreward/tpl/user/task_seller');
	}
	
	
}