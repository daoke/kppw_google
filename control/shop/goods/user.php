<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �û����������б���༭
 * @author Michael
 * @version 3.0
   2012-10-19
 */

class Control_shop_goods_user extends Control_user{
    
	
	/**
	 * @var һ���˵�ѡ����
	 */
	protected static $_default = 'buyer';
	/**
	 * @var �����˵�ѡ����,��ֵ����ѡ��
	 */
	protected static $_left = 'goods';
	
	
	function action_index(){
		
		
		require Keke_tpl::template('control/shop/goods/tpl/user/shop_list');
	}
	
	
	function action_edit(){
		
		require Keke_tpl::template('control/shop/goods/tpl/user/shop_edit');
	}
	
	
	
	
}