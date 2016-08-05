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
$offset = get_input('offset',0);
$limit = 10;
$tag = get_input('tag','');
$form = get_entity($form_id);

if ($form && $form->getSubtype() == 'form:form') {
    set_page_owner(get_loggedin_userid());
    
    $title = sprintf(elgg_echo('form:search_box_results_title'),form_form_t($form,'title'));  
    $entities =  form_search_box_results($form,$tag,$offset,$limit);
    $count =  form_search_box_count($form,$tag);
    $body = form_view_entity_list($entities, $form, $count, $offset, $limit, false, false); 
    page_draw($title,elgg_view_layout("two_column_left_sidebar", '<br />'.elgg_view("form/search_box",array('form_id'=>$form_id)), elgg_view_title($title) . $body));
} else {
    register_error(elgg_echo('form:not_found'));
    forward();
}
?>