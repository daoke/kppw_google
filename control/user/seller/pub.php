<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �û�����-������-��������Ʒ
 * @author Michael
 * @version 2.2
   2012-10-25
 */

class Control_user_seller_pub extends Control_user{
    
	/**
	 * @var һ���˵�ѡ����
	 */
	protected static $_default = 'seller';
    /**
     * 
     * @var �����˵�ѡ����,��ֵ����ѡ��
     */
	protected static $_left = 'pub';
	
	function action_index(){
		Control_user_seller_index::init_nav();
		
		require Keke_tpl::template('user/seller/pub');
	}
	function action_edit(){
		
		require Keke_tpl::template('user/seller/pub_edit');
	}
}