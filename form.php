<?php
/**
 * Elgg form display
 * Displays the specified Elgg form
 * 
 * @package Elgg
 * @subpackage Form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 */

	 // Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Load form model
require_once(dirname(__FILE__)."/models/model.php");
    
// Define context
set_context('form:content');

$form_id = get_input('id',0);
$form_data_id = get_input('d',0);
$preview = get_input('preview',0);

$form = get_entity($form_id);

if ($form && $form->type == 'object' && get_subtype_from_id($form->subtype) == 'form:form') {
    set_page_owner($form->owner_guid);
    if ($form_data_id && ($form_data = form_get_data($form_data_id))) {
        if (get_entity($form_data_id)->canEdit()) {
            $tab_data = form_get_data_for_edit_form($form,$form_data);
        } else {
            register_error(elgg_echo('form:content_not_found'));
            forward();
        }
    } else {
        $tab_data = form_get_data_for_edit_form($form);
    }
    $title = form_form_t($form,'title');    
    $body = elgg_view('form/forms/display_form', array('form'=>$form,'tab_data'=>$tab_data,'preview'=>$preview,'form_data_id'=>$form_data_id));
    
    $pg_owner_entity = elgg_get_page_owner_entity();
    $username = $pg_owner_entity->username;
 
    page_draw($title,elgg_view_layout("two_column_left_sidebar", '<br />'.elgg_view("form/search_box",array('form_id'=>$form_id)), elgg_view_title($title) . $body));
} else {
    register_error(elgg_echo('form:not_found'));
    forward();
}
?>