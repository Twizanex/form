<?php

/**
 * Elgg choice
 * Displays a choice option linked to a search
 * 
 * Tags can be a single string (for one tag) or an array of strings
 * 
 * @package Form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 * @uses $vars['option'] The choice option
 * @uses $vars['label'] The label
 * @uses $vars['internalname'] The internal name of the field
 * @uses $vars['form_id'] The form_id
 */

$type = $vars['type'];
$value = $vars['value'];
$internalname = $vars['internalname'];
$form_id = $vars['form_id'];

if ($type == 'form_data') {
	$qs = "type=form_data&form_id=$form_id";
} else {
	$qs = "type=$type";
}

if (is_array($value)) {
	$value_array = array();
	foreach($value as $key => $label) {
		if (!$label) {
			$label = $key;
		}
		$value_bit = "&form_data[$internalname]=".urlencode($key);	
		$value_array[] = '<a href="'.$vars['url'].'mod/form/search_results_simple.php?'.$qs.$value_bit.'">'.$label.'</a>';
	}
	echo implode(', ',$value_array);
} else {

	if (empty($vars['label'])) {
		$label = $value;
	} else {
		$label = $vars['label'];
	}
	
	$qs .= "&form_data[$internalname]=".urlencode($value);
	
	echo '<a href="'.$vars['url'].'mod/form/search_results_simple.php?'.$qs.'">'.$label.'</a>';
}

?>