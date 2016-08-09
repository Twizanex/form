<?php

	/**
	 * Elgg add search definition
	 * 
	 * @package Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 * 
	 * @uses $vars['form_id'] Optionally, the form to add a search definition for
	 */
	 
$form = $vars['form'];
$form_id = $form->getGUID();
if (isset($vars['search_definition_id']) && $vars['search_definition_id']) {
    $form_action = 'change';
    $search_definition_id = $vars['search_definition_id'];
    $sd = get_entity($search_definition_id);
    $internalname = $sd->internalname;
    $search_title = $sd->title;
    $access_id = $sd->access_id;
    $search_description = $sd->description;   
    $search_fields = $sd->search_fields;
    $search_order = $sd->search_order;
    //$expiryfield = $sd->expiryfield;
    $menu = $sd->menu;
    $button = elgg_echo('form:form_manage_button');
} else {
    $form_action = 'add';
    $search_definition_id = 0;
    $internalname = '';
    $search_title = '';
    $access_id = ACCESS_PUBLIC;
    $search_description = '';
    $search_fields = '';
    $search_order = '';
    //$expiryfield = '';
    $menu = '';
    $button = elgg_echo('form:create_form_button');
}

$search_access_options = array(	ACCESS_PRIVATE => elgg_echo("PRIVATE"),
								ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
								ACCESS_PUBLIC => elgg_echo("PUBLIC"));

$body = '<div class="contentWrapper">';

$body .= '<form action="'.$vars['url'].'action/form/manage_search_definition" method="post">';
// security token
$body .= elgg_view('input/securitytoken');

$body .= elgg_view('input/hidden',array('internalname'=>'form_id', 'value'=>$form_id));
$body .= elgg_view('input/hidden',array('internalname'=>'form_action', 'value'=>$form_action));
$body .= elgg_view('input/hidden',array('internalname'=>'sid', 'value'=>$search_definition_id));

$body .= '<label for="internalname">'.elgg_echo('form:internalname_label');
$body .= elgg_view('input/text',array('internalname'=>'internalname','value'=>$internalname));
$body .= '</label>';
$body .= '<p class="description">'.elgg_echo('form:search_definition_internalname_description').'</p>';

$body .= '<label for="search_title">'.elgg_echo('form:search_title_label');
$body .= elgg_view('input/text',array('internalname'=>'search_title','value'=>$search_title));
$body .= '</label>';
$body .= '<p class="description">'.elgg_echo('form:search_definition_search_title_description').'</p>';

$body .= '<label for="search_description">'.elgg_echo('form:search_description_label');
$body .= elgg_view('input/longtext',array('internalname'=>'search_description','value'=>$search_description));
$body .= '</label>';
$body .= '<p class="description">'.elgg_echo('form:search_definition_search_description_description').'</p>';

$body .= '<label for="search_fields">'.elgg_echo('form:search_field_label');
$body .= elgg_view('input/text',array('internalname'=>'search_fields','value'=>$search_fields));
$body .= '</label>';
$body .= '<p class="description">'.elgg_echo('form:search_field_description').'</p>';

$body .= '<label for="search_order">'.elgg_echo('form:search_order_label');
$body .= elgg_view('input/text',array('internalname'=>'search_order','value'=>$search_order));
$body .= '</label>';
$body .= '<p class="description">'.elgg_echo('form:search_order_description').'</p>';
// TODO: replace expiryfield with the new dated entities when they become available
/*$body .= '<p><label for="expiryfield">'.elgg_echo('form:expiryfield_label');
$body .= elgg_view('input/text',array('internalname'=>'expiryfield','value'=>$expiryfield));
$body .= '</label></p>';
$body .= '<p class="form-field-description">'.elgg_echo('form:expiryfield_description').'</p>';*/

$body .= '<label for="menu">'.elgg_echo('form:menu_label');
$body .= elgg_view('input/text',array('internalname'=>'menu','value'=>$menu));
$body .= '</label>';
$body .= '<p class="description">'.elgg_echo('form:search_menu_description').'</p>';

$body .= '<label for="search_access">'.elgg_echo('form:search_access_label');
$body .= elgg_view('input/pulldown',array('internalname'=>'access_id','value'=>$access_id, 'options_values'=>$search_access_options));
$body .= '</label>';
$body .= '<p class="description">'.elgg_echo('form:search_access_description').'</p>';

$body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>$button));

$body .= '</form>';

$body .= '</div>';

print $body;

?>