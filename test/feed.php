<?php define ( 'IN_KEKE', TRUE );

include '../app_boot.php';

Sys_feed::get_instance()->set_user(5, 'test4')

->set_action('����������')->set_obj('task', '4', '������һ����վ')

->to_feed();


