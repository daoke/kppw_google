<?php defined('IN_KEKE') OR die('access deiend');
/**
 * ��浽��ʱ�䣬�Զ�����
 * @author Michael
 *
 */
Class Sys_cron_ad {
	
	/**
	 * ��ʱ���µ��ڹ�棬�����ڹ����Ϊ0,��������1�����һ��
	 */
	public static function batch_run(){

		Dbfactory::execute(sprintf("update %switkey_ad set is_allow='0' where  end_time>0 and end_time>%d",TABLEPRE,time()));
		
	}
	
}