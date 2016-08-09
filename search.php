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
    
global $CONFIG;

$search_definition_id = get_input('sid',0);
$sd = get_entity($search_definition_id);

// Define context
elgg_set_context('form:content');

if($sd) {
	$form = get_entity($sd->form_id);
	if ($form && $form->profile == 2) {
		// this is searching group profiles
		elgg_set_context('groups');
	}
}
$hidden = get_input('form_data','');

$body = elgg_view('form/forms/search',array('search_definition'=>$sd,'hidden'=>$hidden));

$title = $sd->title;

elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));

?>
