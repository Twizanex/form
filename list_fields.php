<?php

/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * Lists field definitions
 *
 */
 
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Load form model
require_once(dirname(__FILE__)."/models/model.php");
    
// Define context
elgg_set_context('form:admin');

admin_gatekeeper();

global $CONFIG;

$username = get_input('username','');
$user = get_user_by_username($username);
if ($user) {
    $type = get_input('type','');
    if ($type == 'orphan') {      
        //$fields = form_get_orphan_fields($user->getGUID());
        $fields = form_get_orphan_fields(0);             
        $title = elgg_echo('form:list_orphan_fields_title');
    } else {
        //$fields = form_get_all_fields($user->getGUID());
        $fields = form_get_all_fields(0);                
        $title = elgg_echo('form:list_fields_title');
    }
    
    $body = elgg_view('form/forms/list_fields', array('user'=>$user, 'fields'=>$fields, 'page_return_type'=>$type));
        
    elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));
} else {
    register_error(elgg_echo('form:error_no_such_user'));
    forward();
}
?>
