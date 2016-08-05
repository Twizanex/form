<?php

/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * The main function for managing fields.
 *
 */
 
 // Load form model
require_once(dirname(dirname(__FILE__)) . "/models/model.php");
 
global $CONFIG;

$redirect_url = '';

admin_gatekeeper();

// Define context
set_context('form');
        
$form_action = get_input('form_action','');
$type = get_input('type','');
$username = get_input('username','');
$profile = get_input('profile','');

// possible actions: add, change, edit, delete, move, add_existing, copy_existing, add_new

switch($form_action) {
    case "add":
        $form_id = get_input('form_id',0);
        form_set_field_definition();
        system_message(elgg_echo('form:field_add_response'));
        $redirect_url = $CONFIG->wwwroot.'mod/form/manage_form.php?id='.$form_id;
        break;
    case "change":
        $form_id = get_input('form_id',0);
        form_set_field_definition();
        system_message(elgg_echo('form:field_change_response'));
        if ($type == 'all' || $type == 'orphan') {
            if (!$username) {
                $username = get_entity(get_entity($form_id)->owner_guid)->username;
            }
            $redirect_url = $CONFIG->wwwroot.'mod/form/list_fields.php?type='.$type.'&username='.$username;
        } else {                
            $redirect_url = $CONFIG->wwwroot.'mod/form/manage_form.php?id='.$form_id;
        }
        break;
    case "edit":
        $field_id = get_input('id',0,PARAM_INT);
        $form_id = get_input('form_id',0,PARAM_INT);
        $field = form_get_field_definition($field_id);
        $choices = form_get_field_choices($field_id);
        $title = elgg_echo('form:manage_field_title');
        //$body = form_get_field_form($map->form_id,$field);
        $body = elgg_view('form/forms/manage_field', array('form_id'=>$form_id,'field'=>$field,'profile'=>$profile,'choices'=>$choices,'new_field_name'=>'','page_return_type'=>$type,'username'=>$username));
        $redirect_url = '';
        break;
    case "edit_with_field_id":
        $field_id = get_input('id',0);
        $title = elgg_echo('form:manage_field_title');
        $field = form_get_field_definition($field_id);
        $choices = form_get_field_choices($field_id);
        //$body = form_get_field_form(0,$field);
        $body = elgg_view('form/forms/manage_field', array('form_id'=>0,'field'=>$field,'profile'=>$profile,'choices'=>$choices,'new_field_name'=>'','page_return_type'=>$type,'username'=>$username));
        $redirect_url = '';
        break;
    case "remove":
        // remove this field from a form
        $field_id = get_input('id',0);
        $form_id = get_input('form_id',0);
        form_field_remove($form_id,$field_id);
        system_message(elgg_echo('form:field_remove_response'));
        $redirect_url = $CONFIG->wwwroot.'mod/form/manage_form.php?id='.$form_id;
        break;
    case "delete":
        // unlike remove, delete actually deletes the form definition itself 
        // and the references for all forms
        $field_id = get_input('id',0);
        //delete_records('form_fields_map','field_id',$field_id);
        //delete_records('form_fields','ident',$field_id);
        
        form_field_delete($field_id);
        
        $type = get_input('type','');
        if ($type == 'orphan') {
            system_message(elgg_echo('form:orphan_field_delete_response'));
            $redirect_url = $CONFIG->wwwroot.'mod/form/list_fields.php?type=orphan&username='.$username;
        } else {
            system_message(elgg_echo('form:field_delete_response'));
            $redirect_url = $CONFIG->wwwroot.'mod/form/list_fields.php?type=all&username='.$username;
        }
            
        break;
    case "delete_orphans":
        //form_delete_orphan_fields(get_user_from_username($username)->getGUID());
        // change to delete all orphan fields
        form_delete_orphan_fields(0);
        system_message(elgg_echo('form:orphan_delete_all_response'));
        $redirect_url = $CONFIG->wwwroot.'mod/form/list_fields.php?type=orphan&username='.$username;
        break;
    case "move":
        $form_id = get_input('form_id',0);
        $field_id = get_input('id',0);
        $direction = get_input('direction','');
        if ($direction == 'up') {
            form_field_moveup($form_id,$field_id);
        } else if ($direction == 'down') {
            form_field_movedown($form_id,$field_id);
        } else if ($direction == 'top') {
            form_field_movetop($form_id,$field_id);
        } else if ($direction == 'bottom') {
            form_field_movebottom($form_id,$field_id);
        }
        //system_message(elgg_echo('form:field_move_response'));
        //$redirect_url = $CONFIG->wwwroot.'mod/form/manage_form.php?id='.$form_id;
        break;
    case "add_existing":
        $existing_field_name = trim(get_input('existing_field_name',''));
        $form_id = get_input('form_id',0);
        $form = get_entity($form_id);
        //$field_id = form_get_field_id_from_name($existing_field_name,$form->owner_guid);
        // changed to no longer care about form owner
        $field_id = form_get_field_id_from_name($existing_field_name);
        if ($field_id) {        
            if (form_add_existing_field($form_id,$field_id)) {
                system_message(sprintf(elgg_echo('form:field_existing_add_response'), $existing_field_name));
            } else {
                register_error(elgg_echo('form:field_add_error'));
            }
        } else {
            register_error(elgg_echo('form:error_field_does_not_exist'));
        }
                   
        $redirect_url = $CONFIG->wwwroot.'mod/form/manage_form.php?id='.$form_id;
        break;
    case "copy_existing":
        $existing_field_name = get_input('existing_field_name','');
        $new_field_name = get_input('new_field_name','');
        $form_id = get_input('form_id',0);
        $form = get_entity($form_id);
        //$field_id = form_get_field_id_from_name($existing_field_name,$form->owner_guid);
        // changed to no longer care about form owner
        $field_id = form_get_field_id_from_name($existing_field_name);

        if ($field_id) {
            $field = form_get_field_definition($field_id);
            system_message(elgg_echo('form:field_add_description'));
            $title = elgg_echo('form:add_new_title');
            //$body = form_get_field_form($form_id,$field,$form_name = '');
            $body = elgg_view('form/forms/manage_field', array('form_id'=>$form_id,'field'=>$field,'profile'=>$profile,'new_field_name'=>$new_field_name,'page_return_type'=>$type,'username'=>$username));
            $redirect_url = '';
        } else {
            register_error(elgg_echo('form:error_field_does_not_exist'));
            $redirect_url = $CONFIG->wwwroot.'mod/form/manage_form.php?id='.$form_id;
        }
        break;
    case "add_new":
        $new_field_name = get_input('new_field_name','');
        $form_id = get_input('form_id',0);

        // make sure that this field does not already exist
        $form = get_entity($form_id);
        $field_id = form_get_field_id_from_name($new_field_name);
        if ($field_id) {
            register_error(elgg_echo('form:error_field_exists'));
            $redirect_url = $CONFIG->wwwroot.'mod/form/manage_form.php?id='.$form_id;
        } else {
            $title = elgg_echo('form:add_new_title');
            $body = elgg_view('form/forms/manage_field', array('form_id'=>$form_id,'field'=>0,'profile'=>$profile,'new_field_name'=>$new_field_name,'page_return_type'=>$type,'username'=>$username));
            $redirect_url = '';
        }
        break;
}

if ($form_action == 'move') {
	$fields = form_get_fields($form_id);
	echo elgg_view('form/field_list',array('fields' => $fields,'form_id'=>$form_id));
} else if ($redirect_url) {
    forward($redirect_url);
} else {
    page_draw($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));
}
?>
