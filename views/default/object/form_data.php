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
	 */

	 // load form model
	 require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/models/model.php");
	 	 
$form_data = $vars['entity'];
$form = get_entity($form_data->form_id);
if ($form) {
	echo form_view_entities(array($form_data), $form, 'list');
}

?>