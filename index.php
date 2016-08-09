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
    
// Define context
elgg_set_context('form');

elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

$title = elgg_echo('form:list_forms_title');
$body = elgg_view('form/forms/list_forms');
    
elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));
?>
