<?php

/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * The main function for creating and changing forms.
 *
 */

// Load form model
require_once(dirname(dirname(__FILE__)) . "/models/model.php");
 
global $CONFIG;

$redirect_url = '';

admin_gatekeeper();
        
$form_action = get_input('form_action','');
$username = get_input('username','');

if ($form_action == 'add' || $form_action == 'change' ) {
    // TODO - analyse to see if error checking is required
    // Should at least make sure that the user does not try to
    // add a form with an empty or existing form name
    $form = form_set_form_definition();
    
    elgg_set_context('form:admin');
    $form_id = $form->getGUID();
    $fields = form_get_fields($form_id);
    $title = sprintf(elgg_echo('form:manage_form_title'),$form->title,$form->name);
    $vars = array('form' => $form, 'fields' => $fields, 'form_username' => $username);
    $body = elgg_view('form/forms/manage_form',$vars);
    
    if ($form_action == 'add') {
        system_message(elgg_echo('form:create_form_response'));
    } else {
        system_message(elgg_echo('form:manage_form_response'));
    }
    
} else if ($form_action == 'delete') {
    
    $form_id = get_input('id',0);
    $form = get_entity($form_id);
    $username = get_entity($form->owner_guid)->username;
    form_delete($form_id);
    system_message(elgg_echo('form:delete_response'));
    $redirect_url = $CONFIG->wwwroot.'mod/form/manage_all_forms.php?username='.$username;
    
} else if ($form_action == 'translate_status') {
    
    $form_id = get_input('id',0);
    $translate = get_input('translate',0);
    form_set_translation_status($form_id,$translate);
    if ($translate) {
        system_message(elgg_echo('form:translate_on_response'));
    } else {
        system_message(elgg_echo('form:translate_off_response'));
    }
    $redirect_url = $CONFIG->wwwroot.'mod/form/manage_form_translation.php?id='.$form_id;
} else if ($form_action == 'user_content_status') {
    form_set_user_content_status(get_input('user_content_status',0));
    if (!$username) {
        $username = $_SESSION['user']->username;
    }
    system_message(elgg_echo('form:user_content_status_response'));
    $redirect_url = $CONFIG->wwwroot.'mod/form/manage_all_forms.php?username='.$username;
} else if ($form_action == 'manage_group_profile_categories') {
    form_set_group_profile_categories(get_input('group_profile_categories',''));
    system_message(elgg_echo('form:manage_group_profile_categories_response'));
    $redirect_url = $CONFIG->wwwroot.'mod/form/manage_group_profile_categories.php';    
} else {
    register_error(elgg_echo('form:invalid_action'));
    $redirect_url = $CONFIG->wwwroot.'pg/form/'.$username;    
}

if ($redirect_url) {
    forward($redirect_url);
} else { 
    elgg_view_page($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));
}
?>
