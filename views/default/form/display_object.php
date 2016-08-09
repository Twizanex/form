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

echo '<div class="contentWrapper">';
echo form_view_entities(array($vars['form_data']), $vars['form'], 'display');
echo '</div>';

?>