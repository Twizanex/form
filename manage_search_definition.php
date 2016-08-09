<?php

/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * The main form for creating and changing forms.
 *
 */
 
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
    
// Define context
elgg_set_context('form:admin');

admin_gatekeeper();

global $CONFIG;

$search_definition_id = get_input('sid',0);

if ($search_definition_id) {
    $form_id = get_entity($search_definition_id)->form_id;
} else {
    $form_id = get_input('form_id',0);
}

$form = get_entity($form_id);

if ($form) {
    $username = get_entity($form->owner_guid)->username;
    $title = sprintf(elgg_echo('form:search_definition_title'),$form->title);     
        
} else {
    register_error(elgg_echo('form:bad_form_id'));
    forward();
}

$body = elgg_view('form/forms/manage_search_definition',array('form'=>$form,'search_definition_id'=>$search_definition_id));

elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));

?>
