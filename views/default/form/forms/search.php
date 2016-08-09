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
	 require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/models/model.php"); 	 
$sd = $vars['search_definition'];
$search_definition_id = $sd->getGUID();
$form_id = $sd->form_id;
$form = get_entity($form_id);

$hide_category = '';

$hidden_fields = $vars['hidden'];
if ($hidden_fields) {
	$data = array();
	$hidden = array();
	foreach ($hidden_fields as $key => $value) {
		$f = new stdClass;
		$f->value = $value;
		$f->name = $key;
		$data[$key] = $f;
		$hidden[$key] = true;
		if ($key == 'group_profile_category') {
			// special handling
			$hide_category = $value;	
		}
	}
}

$button = elgg_echo('form:search_button');

$body = '<div class="contentWrapper">'.$sd->description.'</div>';
$body .= '<div class="contentWrapper">';

$body .= '<form action="'.$vars['url'].'mod/form/search_results.php" method="get">';
$body .= elgg_view('input/hidden',array('internalname'=>'sid', 'value'=>$search_definition_id));

$namelist = array();
$names = trim($sd->search_fields);
if ($names) {
    foreach(explode(',',$names) as $name) {
        $namelist[] = trim($name);
    }
    if ($hidden_fields) {
    	$results = form_display_filtered($form,$namelist,$data,false,$hidden);
    } else {
    	$results = form_display_filtered($form,$namelist,null,false);
    }
    
    if ($results) {
        foreach($results as $item) {
            $body .= $item->html;
        }
    }
}

if ($hide_category) {
	$body .= elgg_view('input/hidden',array('internalname'=>'_hide_category', 'value'=>$hide_category));
}

$body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>$button));

$body .= '</form>';
$body .= '</div>';

print $body;

?>
