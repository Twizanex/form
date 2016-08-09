<?php

	/**
	 * Elgg display search form
	 * 
	 * @package Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 * 
	 * @uses $vars['form_id'] Optionally, the form to add a search definition for
	 */

 // load form model
 require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/models/model.php");
  // load form profile model
 require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/models/profile.php");
  
$type = get_input('type','');

$fd = get_input('form_data',array());

if ($type == 'user') {
 	// load flexprofile model
 	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/flexprofile/models/model.php");
 	$form = flexprofile_get_profile_form();
} else if ($type == 'group') {
 	// load flexgroupprofile model
 	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/flexgroupprofile/models/model.php");
 	$form = flexgroupprofile_get_profile_form();
 	elgg_set_context('groups');
} else if ($type == 'file') {
 	// load flexgroupprofile model
 	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/flexfile/models/model.php");
 	$form = flexfile_get_file_form();
 	elgg_set_context('file');
} else {
	$form_id = (int) get_input('form_id',0);
	$form = get_entity($form_id);
}

$offset = (int) get_input('offset',0);
$limit = 5;

$result = form_get_data_with_search_conditions_simple($fd,$type,$form->getGUID(),$limit,$offset);
$count = $result[0];
$entities = $result[1];

if ($entities) {
	elgg_set_context('search');
	if (in_array((int) $form->profile, array(1,2,3))) {
		echo elgg_view_entity_list($entities, $count, $offset, $limit, false, false);
	} else {
		echo form_view_entity_list($entities, $form, $count, $offset, $limit, false, false);
	}
	elgg_set_context('form');
} else {
    echo '<p>'.elgg_echo('form:no_search_results').'</p>';
}

?>
