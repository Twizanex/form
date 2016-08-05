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
set_context('form');

set_page_owner(get_loggedin_userid());

$title = elgg_echo('form:list_forms_title');
$body = elgg_view('form/forms/list_forms');
    
page_draw($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));
?>