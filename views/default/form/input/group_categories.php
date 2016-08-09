<?php
$categories = form_get_group_profile_categories();
$options = array();
if ($categories) {
	foreach(explode("\n",$categories) as $category) {
		// not sure why this trim is necessary
		$category = trim($category);
		$options[$category] = $category;
	}
}
$vars['options'] = $options;
echo elgg_view('input/pulldown',$vars);
?>