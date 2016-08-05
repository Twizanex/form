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
set_context('form:admin');

admin_gatekeeper();

global $CONFIG;

$form_id = get_input('id',0);
$username = get_input('username','');
$profile = get_input('profile','');

if ($form_id) {
    $form = get_entity($form_id);
    if ($form) {
        $fields = form_get_fields($form_id);
        $owner = get_entity($form->owner_guid);
        $username = $owner->username;  
        $vars = array('form' => $form,'fields'=>$fields,'form_username'=>$username);
        $title = sprintf(elgg_echo('form:manage_form_title'),$form->title,$form->name);
        
    } else {
        register_error(elgg_echo('form:bad_form_id'));
        forward($CONFIG->wwwroot.'pg/form/'.$username);
    }
} else {
    $vars = array('form' => '','form_username'=>$username,'profile'=>$profile);
    $title = elgg_echo('form:create_form_title');
}

$body = elgg_view('form/forms/manage_form',$vars);

page_draw($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));

?>