<?php defined('IN_KEKE') or die('access denied');
/**
 * ���ݱ�ǩԶ�̵���
 * @author Michael
 * @version 3.0 2012-12-19 
 *
 */
class Control_tag extends Controller{
	
	function action_index(){
		$tag_name =$_GET['t'];
		Sys_tag::factory()->readtag($tag_name);
		$content = ob_get_contents();
		ob_end_clean();
		$arr = array("'"=>'\'',"\r\n"=>"","\n"=>'');
		$content = strtr($content,$arr);
		echo("document.write('".$content."');");
	}
	
}
