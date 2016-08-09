<?php

/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * Lists the current forms
 *
 */
 
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
    
// Define context
elgg_set_context('form:admin');

admin_gatekeeper();

global $CONFIG;

$form_id = get_input('form_id',0);
$user = get_entity(get_entity($form_id)->owner_guid);
if ($user) {
    $username = $user->username;
    elgg_set_page_owner_guid($user->getGUID());
    
    $form = get_entity($form_id);

    $title = sprintf(elgg_echo('form:list_search_definitions_title'),$form->title);
    $body = elgg_view('form/forms/list_search_definitions', array('form_id'=>$form_id));

    elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));
} else {
    register_error(elgg_echo('form:error_no_such_user'));
    forward();
}

?>
