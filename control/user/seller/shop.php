<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �û�����-������-���̹���
 * @author Michael
 * @version 2.2
   2012-10-25
 */

class Control_user_seller_shop extends Control_user{
    
	/**
	 * @var һ���˵�ѡ����
	 */
	protected static $_default = 'seller';
    /**
     * 
     * @var �����˵�ѡ����,��ֵ����ѡ��
     */
	protected static $_left = 'shop';
	
	/**
	 * ���̿�ͨ����������
	 */
	function action_index(){
		global $_K,$_lang;
		//�Ƿ���֤
		$is_auth = $this->get_is_auth();
		$data_arr = DB::select()->from('witkey_shop')->where('uid = '.$_SESSION['uid'])->get_one()->execute();
		
		require Keke_tpl::template('user/seller/shop');
	}
	/**
	 * �����б�
	 */
	function action_case(){
	
	
	
		require Keke_tpl::template('user/seller/shop_case');
	}
	/**
	 * �����༭�����
	 */
	function action_case_add(){
		require Keke_tpl::template('user/seller/shop_case_add');
	}
	/**
	 * �������ݱ���
	 */
	function action_case_save(){
		
	}
	/**
	 * ��Ա�б�
	 */
	function action_member(){
	
	
		require Keke_tpl::template('user/seller/shop_member');
	}
	/**
	 * ��Ա�༭���
	 */
	function action_member_add(){
		
		require Keke_tpl::template('user/seller/shop_member_add');
	}
	/**
	 * ��Ա���ݱ���
	 */
	function action_member_save(){
		
	}
	
	/**
	 *  �������ݱ��� 
	 */
	function action_save(){
		
	}
	/**
	 *  �ж��û�����
	 * @return 
	 */
	function get_user_type(){
		return DB::select('user_type')->from('witkey_space')->where("uid = ".$_SESSION['uid'])->get_count()->execute();
	}
	/**
	 * �ж��Ƿ�ͨ����֤
	 * @return 
	 */
	function get_is_auth(){
		if($this->get_user_type() == 1){
			$auth_type = 'realname';
		}else {
			$auth_type = 'enterprise';
		}
		return DB::select($auth_type)->from('witkey_member_auth')->where("uid = ".$_SESSION['uid'])->get_count()->execute();
	}
}