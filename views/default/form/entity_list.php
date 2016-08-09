<?php

// load form model
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/models/model.php");

$context = $vars['context'];
$offset = $vars['offset'];
$entities = $vars['entities'];
$form = $vars['form'];
$limit = $vars['limit'];
$count = $vars['count'];
$baseurl = $vars['baseurl'];
$context = $vars['context'];
$viewtype = $vars['viewtype'];

$html = "";
$nav = "";

if (isset($vars['viewtypetoggle'])) {
	$viewtypetoggle = $vars['viewtypetoggle'];
} else {
	$viewtypetoggle = true;
}

if ($context == "search" && $count > 0 && $viewtypetoggle) {
	$nav .= elgg_view("navigation/viewtype",array(
		
												'baseurl' => $baseurl,
												'offset' => $offset,
												'count' => $count,
												'viewtype' => $viewtype,
		
	));
}
	
$nav .= elgg_view('navigation/pagination',array(
	
												'baseurl' => $baseurl,
												'offset' => $offset,
												'count' => $count,
												'limit' => $limit,
	
));
	
$html .= $nav;
	
if ($fullview) {
	$viewtype = 'display';
}

if (is_array($entities) && sizeof($entities) > 0) {

	$html .= form_view_entities($entities, $form, $viewtype);
}
	
if ($count)
$html .= $nav;

echo $html;

?>