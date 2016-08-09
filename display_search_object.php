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
elgg_set_context('form:content');

global $CONFIG;

$search_definition_id = get_input('sid',0);

if ($search_definition_id) {
	$sd = get_entity($search_definition_id);
	$form_id = $sd->form_id;
} else {
	$form_id = get_input('form_id',get_input('id',0));
}

$form_data_id = get_input('d',0);

$body = elgg_view('form/display_search_object',array('form_id'=>$form_id, 'form_data_id'=>$form_data_id));

$title = elgg_echo('form:search_results_title');

elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));

?>
