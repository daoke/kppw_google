<?php defined('IN_KEKE') or 	exit('Access Denied');
/**
 * 计件悬赏任务初始化配置文件
 */
//子菜单ID
$sub_menu_arr[] = array(
		'resource_id'=>204,
		'resource_url'=>'index.php/task/preward_admin_list',
		'resource_name'=>'任务列表',
		'submenu_id'=>62);
$sub_menu_arr[] = array(
		'resource_id'=>205,
		'resource_url'=>'index.php/task/preward_admin_config',
		'resource_name'=>'任务配置',
		'submenu_id'=>62);
//父菜单ID
$menu_arr = array(
		//ID
		'submenu_id'=>'62',
		//中文件名称 
		'submenu_name'=>'计件悬赏',
		//一级菜单code
		'menu_name'=>'task',
		'listorder'=>'3'
);


$init_config = array(
	'model_id'=>3,
	'model_code'=>'preward',
	'model_name'=>'计件悬赏',
	'model_type'=>'task',
	'model_dev'=>'kekezu',
	'model_status'=>1,
	'on_time'=>'2012-10-27',
	'listorder'=>'1',
	//配置信息
	'config'=>array(
	'audit_cash'=>10,
	'is_auto_adjourn'=>1,
	'adjourn_day'=>2,
	'deduct_scale'=>1,
	'defeated_money'=>2,
	'task_min_cash'=>10,
 	'show_limit_time'=>1,
	'agree_sign_time'=>10,
	'agree_complete_time'=>5)
);