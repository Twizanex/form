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
	 	 
$form = get_entity($vars['form_id']);
$fd = get_entity($vars['form_data_id']);

if (isset($_SESSION['last_search_qs'])) {
    $qs = $_SERVER["QUERY_STRING"];
    // remove the form data id from the query string first
    $qsi = strpos($qs,'&');
    $qs = substr($qs,$qsi+1);
    
    $return_to_search_results = '<p><a href="'.$CONFIG->wwwroot.'mod/form/search_results.php?'.$qs
        .'">'.elgg_echo('form:return_to_search_results').'</a></p>';
} else {
    $return_to_search_results = '';
}
echo '<div class="contentWrapper">';           
echo $return_to_search_results;

echo form_view_entities(array($fd), $form, 'display');

echo $return_to_search_results;

echo '</div>';

?>