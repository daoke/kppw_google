<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �û����������б���༭
 * @author Michael
 * @version 3.0
   2012-10-19
 */

class Control_task_mreward_user extends Control_user{
    
	
	/**
	 * @var һ���˵�ѡ����
	 */
	protected static $_default = 'buyer';
	/**
	 * @var �����˵�ѡ����,��ֵ����ѡ��
	 */
	protected static $_left = 'mreward';
	
	/**
	 * �ҷ���������
	 */
	function action_index(){
		
		require Keke_tpl::template('control/task/mreward/tpl/user/task_list');
	}
	/**
	 * ����������༭  
	 */
	function action_edit(){
		
		require Keke_tpl::template('control/task/mreward/tpl/user/task_edit');
	}
	/**
	 * �Ҳ��������
	 */
	function action_seller(){
		self::$_default = 'seller';
		self::$_left = 'mreward';
		
		
		require Keke_tpl::template('control/task/mreward/tpl/user/task_seller');
	}
	
	
}