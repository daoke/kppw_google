<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * ���������״�����
 * @author Michael
 * @version 3.0
   2012-12-24
 */

class Control_task_sreward_trade extends Sys_task_trade{

	
	
	
	/**
	 * @return ����״̬ array($task_status=>array('scode'=>'wait','status'=>'������'))
	 */
	public static function task_status() {
		$arr = DB::select()->from('witkey_status')->where("stype='task' and model_code ='sreward'")->cached(9999)->execute();
		return Arr::get_arr_by_key($arr, 'sid');
	}
	
	/**
	 * @return ���״̬
	 */
	public static function work_status() {
		$arr = DB::select()->from('witkey_status')->where("stype='work' and model_code ='sreward'")->cached(9999)->execute();
		return Arr::get_arr_by_key($arr, 'sid');
	}

}