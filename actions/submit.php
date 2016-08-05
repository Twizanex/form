<?php

/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * Handles form submissions.
 *
 */

// Load form model
require_once(dirname(dirname(__FILE__)) . "/models/model.php");
 
global $CONFIG;

// Define context
set_context('form:content');

$form_data_id = get_input('form_data_id',0);
$form_id = get_input('form_id',0);
$preview = get_input('preview',0);

$form = get_entity($form_id);
$title = $form->title;  

if ($preview) {
    $body = '<p class="form-description">'.elgg_echo('form:preview_results_description').'</p>';
    $form_data = form_get_data_from_form_submit($form_id);
    $maps = form_get_maps($form_id);
    if ($maps) {
        foreach ($maps as $map) {
            $field = get_entity($map->field_id);
            $value = isset($form_data[$field->internal_name])?$form_data[$field->internal_name]:'';
            if (is_array($value)) {
            	$value = implode(', ',$value);
            }
            $body .= '<p><b>'.$field->title.' ('.$field->internal_name.') : '.$value.'</p>';
        }
    }

} else {
    $result = form_set_data_from_form($form_data_id);
    if ($result->error_status) {
        if ($result->error_reason == 'missing') {
            register_error(elgg_view('form/missing_error',array('missing'=>$result->missing)));
        } else if ($result->error_reason == 'save_failed') {
            register_error(elgg_echo('form:err_save_failed'));
        }
        // redisplay the form
        
        $tab_data = form_get_data_for_edit_form($form,$result->form_data);  
        $body = elgg_view('form/forms/display_form', array('form'=>$form,'tab_data'=>$tab_data,'preview'=>$preview));
    } else {
    	// display response
    	$body = elgg_view('form/response',array('form'=>$form));
    }
}  

page_draw($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));

?>