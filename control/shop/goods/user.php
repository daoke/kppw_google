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
	protected static $_default = 'seller';
	/**
	 * @var �����˵�ѡ����,��ֵ����ѡ��
	 */
	protected static $_left = 'goods';
	
 	/**
	 * �������Ʒ������Ϣ
	 */
  	function action_index(){
  		self::$_default = 'buyer';
		Control_user_buyer_index::init_nav();
	
		require Keke_tpl::template('control/shop/goods/tpl/user/buyer');
	}  
	
 	/**
	 * ����������Ʒ����
	 */
	function action_seller(){
			
	
		require Keke_tpl::template('control/shop/goods/tpl/user/seller');
	}
	
	/**
	 * ��������Ʒ�б�
	 */
	function action_pub(){
		 self::$_left .= 'pub';
		 
		require Keke_tpl::template('control/shop/goods/tpl/user/pub');
	}
	/**
	 * ��Ʒ�༭ 
	 */
	function action_edit(){
		self::$_left .= 'pub';
		Control_user_seller_index::init_nav();
		require Keke_tpl::template('control/shop/goods/tpl/user/pub_edit');
	}
	
	
	
	
}