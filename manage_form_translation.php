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

// Load form model
require_once(dirname(__FILE__)."/models/model.php");
    
// Define context
elgg_set_context('form:admin');

admin_gatekeeper();

global $CONFIG;

$form_id = get_input('id',0);
$username = get_input('username','');
$profile = get_input('profile','');

$view_all_link_text = elgg_echo('form:view_all_forms');

$form = get_entity($form_id);
if ($form) {
    $fields = form_get_fields($form_id);
    $owner = get_entity($form->owner_guid);
    $username = $owner->username;  
    $vars = array('form' => $form,'fields'=>$fields,'username'=>$username);
    $title = sprintf(elgg_echo('form:manage_translations_title'),$form->title,$form->name);
    
} else {
    register_error(elgg_echo('form:bad_form_id'));
    forward($CONFIG->wwwroot.'pg/form/'.$username);
}

$body = elgg_view('form/forms/manage_form_translation',$vars);

elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));

?>
