<?php

/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * Displays a list of user-generated content
 *
 */
 
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
    
// Define context
set_context('form:admin');

global $CONFIG;

admin_gatekeeper();

$username = get_input('username');
if ($username) {
	$user = get_user_by_username($username);
} else {
	$user = get_loggedin_user();
}

if ($user) {    
    set_page_owner($user->getGUID());

    $body = elgg_view('form/forms/manage_all_forms',array('username'=>$username));
    
    $title = elgg_echo('form:manage_forms_title');
    
    page_draw($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));
} else {
    register_error(elgg_echo('form:error_no_such_user'));
    forward();
}    

?>