<?php

/**
 * Elgg form display
 *
 * @package Elgg
 * @subpackage Form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 */

$tab_data = $vars['tab_data'];
$form = $vars['form'];
$preview = $vars['preview'];
$form_data_id = $vars['form_data_id'];

if (isset($vars['description'])) {
	$description = $vars['description'];
} else {
	$description = form_t($form,'description');
}

if ($preview) {
	$body = '<p class="form-description">'.elgg_echo('form:preview_description').'</p>';
} else {
	$body = '';
}

$body .= elgg_view('input/hidden',array('internalname'=>'form_id', 'value'=>$form->getGUID()));
$body .= elgg_view('input/hidden',array('internalname'=>'preview', 'value'=>$preview));
$body .= elgg_view('input/hidden',array('internalname'=>'form_data_id', 'value'=>$form_data_id));
$body .= "<p class=\"form-description\">$description</p>";

if (count($tab_data['main']) > 1) {
	$body .= <<<END
	<script type="text/javascript" src="{$CONFIG->wwwroot}mod/form/tabber/tabber.js"></script>
	<link rel="stylesheet" href="{$CONFIG->wwwroot}mod/form/tabber/example.css" type="text/css" media="screen" />
END;
	$body .= '<div class="tabber">';
	$body .= '<div class="tabberloading" ></div>';
	foreach($tab_data['main'] as $tab => $html) {
		if ($html) {
			$body .= "<div class=\"tabbertab\" title=\"$tab\">";
			$body .= $html;
			$body .= "</div>\n";
		}
	}
	$body .= '</div>';
} else if (count($tab_data['main']) == 1) {
	foreach($tab_data['main'] as $tab => $html) {
		$body .= $html;
	}
}
echo $body.$tab_data['extra'];
?>