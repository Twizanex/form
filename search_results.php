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
$sd = get_entity($search_definition_id);

if($sd) {
	$form = get_entity($sd->form_id);
	if ($form && ($form->profile == FORM_GROUP_PROFILE)) {
		// this is searching group profiles
		elgg_set_context('groups');
	} else if ($form && ($form->profile == FORM_FILE)) {
		// this is searching files
		elgg_set_context('file');
	}
}

$_SESSION['last_search_qs'] = $_SERVER["QUERY_STRING"];

$body = elgg_view('form/search_results',array('search_definition'=>$sd));
if ($category = get_input('_hide_category','')) {
	$body .= elgg_view('form/forms/search',array('search_definition'=>$sd,'hidden'=>array('group_profile_category'=>$category)));
} else {
	$body .= elgg_view('form/forms/search',array('search_definition'=>$sd));
}

$title = elgg_echo('form:search_results_title');

elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));

?>
