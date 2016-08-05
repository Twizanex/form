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
set_context('form:content');

global $CONFIG;

$form_id = get_input('id',0);
$form = get_entity($form_id);
$username = get_input('username');
$form_view = get_input('form_view');
$callback = get_input('callback');

//TODO: make sure it is safe and then remove the next two lines

$_SESSION['last_search_qs'] = null;
$_SESSION['last_view_qs'] = $_SERVER["QUERY_STRING"];

$nav = elgg_view('form/nav',array('form_id'=>$form_id,'form_view'=>$form_view,'enable_recommendations'=>$form->allow_recommendations));

$body = elgg_view('form/my_forms',array('form'=>$form, 'username'=>$username, 'form_view'=>$form_view));

if ($callback) {
	echo $nav.'<br />'.$body;
} else {
	$title = $form->title;
	$body = '<div class="contentWrapper"><div id="form_wrapper">'.$nav.'<br />'.$body.'</div></div>';
	if (trim($form->listing_description)) {
		$listing_description = '<div class="contentWrapper">';
		$listing_description .= $form->listing_description;
		$listing_description .= '</div>';
		$body = $listing_description.$body;
	}
	page_draw($title,elgg_view_layout("two_column_left_sidebar", '<br />'.elgg_view("form/search_box",array('form_id'=>$form_id)), elgg_view_title($title) . $body));
}

?>