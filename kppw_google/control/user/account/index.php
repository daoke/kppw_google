<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �û�����-�˺Ź�����ҳ
 * @author Michael
 * @version 2.2
   2012-10-25
 */

class Control_user_account_index extends Control_user{
    
	/**
	 * @var һ���˵�ѡ����
	 */
	protected static $_default = 'account';
    /**
     * 
     * @var �����˵�ѡ����,��ֵ����ѡ��
     */
	protected static $_left = NULL;
	
	function action_index(){
		
		
		
		require Keke_tpl::template('user/account/index');
	}
}