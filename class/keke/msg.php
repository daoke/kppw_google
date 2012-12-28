<?php defined ( "IN_KEKE" ) or die ( "Access Denied" );
/**
 * ʹ������
 * Keke_msg::instance()->to_user($_SESSION['uid'])->set_tpl($msg_type)->set_var($arr)->send();
 * $msg_type Ϊģ�����ƣ�$arr ģ����Ҫ�滻�ı��� 
 * keke���ų�����
 * @author Michael
 * 2012-10-08
 *
 */
abstract class  Keke_msg {
	
	/**
	 * @var Ĭ�Ͻӿ�
	 */
	public static $default = 'keke';
	/**
	 * @var ģ��
	 */
	public static $_tpl ;
	/**
	 * @var ʵ��
	 */
	public static $instances = array ();
	/**
	 * @param string $name 
	 * @return Keke_msg_keke
	 */
	public static function instance($name = null ) {
		if ($name === null) {
			$name = Keke_msg::$default;
		}
		
		if (isset ( Keke_msg::$instances [$name] )) {
			return Keke_msg::$instances [$name];
		}
		$class = "Keke_msg_{$name}";
		Keke_msg::$instances [$name] = new $class ();
		//var_dump(Keke_msg::$instances [$name]);die;
		return Keke_msg::$instances [$name];
	}
	
	abstract public function send();
	
 
}
