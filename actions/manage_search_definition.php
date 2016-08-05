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
$search_definition_id = get_input('sid',0);

if ($form_action == 'add' || $form_action == 'change' ) {
    // TODO - analyse to see if error checking is required
    // Should at least make sure that the user does not try to
    // add a search definition with an empty or existing name
    $sd = form_set_search_definition($search_definition_id);
    $form_id = $sd->form_id;
    
    if ($form_action == 'add') {
        system_message(elgg_echo('form:create_search_definition_response'));
    } else {
        system_message(elgg_echo('form:manage_search_definition_response'));
    }
    
} else if ($form_action == 'delete') {
    
    $form_id = get_entity($search_definition_id)->form_id;
    form_search_definition_delete($search_definition_id);
    system_message(elgg_echo('form:delete_search_definition_response'));
}

forward($CONFIG->wwwroot.'mod/form/list_search_definitions.php?form_id='.$form_id);

?>