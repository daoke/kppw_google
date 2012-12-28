<?php  defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * �������񷢲�
 * @author Michael
 * @version 2.2
   2012-10-19
 */

class Control_task_sreward_pub extends Control_task_task{
     
    private $_tpl = 'control/task/sreward/tpl/';
    /**
     * @var �����Ƿ����
     */
    private $_task_audio;
	/**
	 * @var ����Ҫ����Ǯ
	 */
    private $_need_pay;
    /**
     * @var ��ʽ����ID
     */
    private $_task_id;
    /**
     * @var ����ģ������
     */
    private $_conf;
    
    function before(){
    	parent::before();
    	//��ʱ������Ϣ,�����޸�ʱ��
    	$id = $this->get_tmp_task_id();
    	$this->_task_info = DB::select()->from('witkey_task_temp')->where("id='$id'")->get_one()->execute();
    	
    }
    /**
     * ��һ��
     */
	function action_index(){
		/**
		 * ��ʱ������Ϣ,����ʱ����
		 */
		$this->before();

		$task_info = $this->_task_info;
		
		if($task_info){
			$this->set_tmp_task_id($task_info['id']);
		}
		
		require Keke_tpl::template($this->_tpl.'release1');
	}
	/**
	 * �ڶ���,������ʱ���񣬻����Ǹ�����ʱ����
	 */
	function action_step2(){
		$task_info = $this->_task_info;
		
		if($_POST){
			if($task_info['id']){
				DB::update('witkey_task_temp')->set(array('task_cash','sub_time'))
				->value(array((float)$_POST['task_cash'],(int)$_POST['sub_time']))
				->where("id='{$task_info['id']}'")->execute();
			}else{
				$task_id = DB::insert('witkey_task_temp')->set(array('task_cash','sub_time','model_code','on_time'))
				->value(array((float)$_POST['task_cash'],(int)$_POST['sub_time'],'sreward',SYS_START_TIME))->execute();
				$this->set_tmp_task_id($task_id);
			}
		}
		
		require Keke_tpl::template($this->_tpl.'release2');
	}
	/**
	 * ��������������������
	 */
	function action_step3(){
		
		if($_POST){
			$_POST = Keke_tpl::chars($_POST);
			$columns = array('task_title','task_desc','task_file','task_indus','task_contact');
			$values = array($_POST['task_title'],$_POST['task_desc'],$_POST['task_file'],$_POST['task_indus'],$_POST['task_contact']);
			$id= $this->get_tmp_task_id();
			DB::update('witkey_task_temp')->set($columns)->value($values)->where("id='$id'")->execute();
		}
		//����ֱ��д��������,���渽����ID,���񷢲��ɹ�����¸�����obj_id,obj_type,
		
		$this->before();
		$task_info = $this->_task_info;
		
		require Keke_tpl::template($this->_tpl.'release3');
	}
	/**
	 *  ���Ĳ������濪Ʊ��Ϣ���ж��û��Ƿ�Ҫ��¼��û�е�¼��������¼ҳ�棬
	 *  ��¼��󣬳������������������ǰ����
	 */
	function action_step4(){
		if($_POST){
			$_POST = Keke_tpl::chars($_POST);
			//��Ʊ��Ϣ
			if((bool)$_POST['allow_fp']){
				$columns = array('fp_title','fp_linxiren','fp_address','fp_zip','fp_mobile','fp_use');
				$values = array($_POST['fp_title'],$_POST['fp_linxiren'],$_POST['fp_address'],$_POST['fp_zip'],$_POST['fp_mobile'],intval((bool)$_POST['fp_use']));
				$id= $this->get_tmp_task_id();
				DB::update('witkey_task_temp')->set($columns)->value($values)->where("id='$id'")->execute();
			}
		}
		//�ж��û��Ƿ��е�¼
		if(Keke_user_login::instance()->logged_in()===FALSE){
			Cookie::set('last_page', $this->request->uri());
			$this->request->redirect('login');
		}
		$this->before();
		
		$this->pub_task($this->_task_info);
		
	}
	/**
	 * ����������Ϣ
	 */
	function pub_task($task_info){
		 
		$this->save_task_info($task_info);
		
		//���淢Ʊ��Ϣ
		$this->save_fp_info($task_info);
		 
		
		//���񷢲�֪ͨ
		$this->task_msg($task_info);
		
		if($this->_need_pay){
			//�������������ɸ����
			$order_id = $this->task_order($task_info);
			Keke::show_msg('�û�����,���ȳ�ֵ',"user/finance_recharge?order_id=$order_id&cash=$this->_need_pay",'error');
		}elseif($this->_task_audio){
			Keke::show_msg('��������У���̨�ᾡ��������!',"task/$this->_task_id",'info');				
		}else{
			Keke::show_msg('���񷢲��ɹ�',"task/$this->_task_id");
		}
		
	}
	/**
	 * ����������Ϣ
	 * @param array $task_info
	 * @return int $task_id
	 */
	function save_task_info($task_info){
		//����Ĳ�����Ϣ
		$uid = $_SESSION['uid'];
		
		$model_list = Keke::init_model();
		
		$model_info = $model_list[1];
		
		$this->_conf = $model_conf = unserialize($model_info['config']);
		
		$profit_rate = (int)$model_conf['task_rate'];
		$fail_rate = (int)$model_conf['task_fail_rate'];
		$auto_bid = $model_conf['auto_bid']=='yes'?1:0;
		$real_cash = $task_info['task_cash']*((int)$profit_rate/100);
		$sub_time = (int)$task_info['sub_time']*3600*24+SYS_START_TIME;
		//�����
		$audit_cash = (float)$model_conf['audit_cash'];
		
		$columns = array('task_cash','real_cash','start_time','sub_time','model_id','profit_rate','fail_rate',
						 'task_title','task_desc','indus_id',
						 'uid','username','contact','is_auto_bid');
		$values = array($task_info['task_cash'],$real_cash,SYS_START_TIME,$sub_time,1,$profit_rate,$fail_rate,
						$task_info['task_title'],$task_info['task_desc'],$task_info['task_indus'],
						$uid,$_SESSION['username'],$task_info['task_contact'],$auto_bid	);
		
		//���
		$task_id = (int)DB::insert('witkey_task')->set($columns)->value($values)->execute();
		//����
		$ispay = Sys_finance::get_instance($uid)->set_action('pub_task')
		
		->set_mem(array(':model_name'=>'sreward',':task_id'=>$task_id,':task_title'=>$task_info['task_title']))
		
		->set_obj('task', $task_id)->cash_out($task_info['task_cash']);
		
		$status = 0;
		if($ispay<0){
			$this->_need_pay = abs($ispay);
		}else{
			$status = $task_info['task_cash']>=$audit_cash?2:1;
		}
		
		if($status===1){
			$this->_task_audio = TRUE;
		}
		
		DB::update('witkey_task')->set(array('task_status'))->value(array($status))->where("task_id = '$task_id'")->execute();
		
		$this->_task_id = $task_id;
		
		return $task_id;
	}
	/**
	 * ���淢��Ϣ
	 * @param array $fp_info
	 */
	function save_fp_info($fp_info){
		if(Keke_valid::not_empty($fp_info['fp_title'])===FALSE){
			return FALSE;
		}
		$arr = array('uid'=>$_SESSION['uid'],
				'fp_title'=>$fp_info['fp_title'],
				'fp_linxiren'=>$fp_info['fp_linxiren'],
				'fp_zip'=>$fp_info['fp_zip'],
				'fp_address'=>$fp_info['fp_address'],
				'fp_mobile'=>$fp_info['fp_mobile'],
				'fp_use'=>$fp_info['fp_use'],
				'obj_type'=>'task',
				'obj_id'=>$this->_task_id				
				);
		DB::insert('witkey_invoice')->set(array_keys($arr))->value(array_values($arr))->execute();
	}
	/**
	 * ����֪ͨ,����̬����
	 */
	function task_msg($task_info){
		$msg_type = 'task_pub';
		$arr = array('{������}'=>$this->_task_id,'{�������}'=>$task_info['task_title']);
		$arr['{��ʼʱ��}'] = date('Y-m-d',SYS_START_TIME);
		if($this->_need_pay){
		   $arr['{����״̬}'] = "������";
		   $arr['{Ͷ�����ʱ��}'] = 'NULL';
		   $arr['{ѡ�����ʱ��}'] = 'NULL';
		}elseif($this->_task_audio){
			$arr['{����״̬}'] = "�����";
			$arr['{Ͷ�����ʱ��}'] = 'NULL';
			$arr['{ѡ�����ʱ��}'] = 'NULL';
		}else{
			$arr['{����״̬}'] = "Ͷ����";
			$arr['{Ͷ�����ʱ��}'] = date('Y-m-d',((int)$task_info['sub_time']*3600*24)+SYS_START_TIME);
			$arr['{ѡ�����ʱ��}'] = date('Y-m-d',(((int)$task_info['sub_time']+(int)$this->_conf['choose_time'])*3600*24)+SYS_START_TIME);
		}
		
		Keke_msg::instance()->to_user($_SESSION['uid'])->set_tpl($msg_type)->set_var($arr)->send();
		
	}
	/**
	 * ���񸶿��
	 * @param array $task_info
	 */
	function task_order($task_info){
		if($this->_need_pay){
			return Sys_order::create_order(1, '', '', $task_info['task_title'], $task_info['task_cash'], '','wait');
		}
		return FALSE;
	}
	
	/**
	 * ���񷢲��ƹ�,�����б��ƹ㣬�����������ʱ���ٴ���
	 */
	
	
}