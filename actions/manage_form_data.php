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
        
$form_action = get_input('form_action','');
$form_data_id = get_input('d',0);
$form_data = get_entity($form_data_id);

if ($form_action == 'delete') {
	$form_id = $form_data->form_id;
    if (form_delete_data($form_data_id)) {
    	system_message(elgg_echo('form:delete_data_response'));
    } else {
    	register_error(elgg_echo('form:delete_error'));
    }
    forward($CONFIG->wwwroot.'mod/form/form.php?id='.$form_id);
} else if ($form_action == 'recommend') {
    if (form_recommend($form_data_id)) {
        system_message(elgg_echo('form:recommend_response'));
    } else {
        register_error(elgg_echo('form:recommend_error'));
    }
    
    forward($form_data->getUrl());
}

?>