<?php
$options = array(elgg_echo('form:yes')=>'yes',
	elgg_echo('form:no')=>'no',
);

if (form_get_user_content_status()) {
	$form_user_content_area = 'yes';
} else {
	$form_user_content_area = 'no';
}

$body = '';

$body .= elgg_echo('form:user_content_status_title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[user_content_area]','value'=>$form_user_content_area,'options'=>$options));

if (elgg_get_plugin_setting('register_user_content', 'form') == 'yes') {
	$form_register_user_content = 'yes';
} else {
	$form_register_user_content = 'no';
}

$body .= elgg_echo('form:user_content_register_title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[register_user_content]','value'=>$form_register_user_content,'options'=>$options));

if (elgg_get_plugin_setting('admin_search_mail', 'form') == 'yes') {
	$form_admin_search_mail = 'yes';
} else {
	$form_admin_search_mail = 'no';
}

$body .= elgg_echo('form:admin_search_mail_title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[admin_search_mail]','value'=>$form_admin_search_mail,'options'=>$options));


echo $body;

?>
