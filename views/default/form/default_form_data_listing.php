<?php

/**
 * Default form data listing
 * 
 * @package form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2009
 * @link http://radagast.biz/
 */

	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	$icon = elgg_view(
			"profile/icon", array(
									'entity' => $owner,
									'size' => 'small',
								  )
		);
	$info = '<p><a href="'.$vars['entity']->getURL().'">'.elgg_echo('form:submission_to').'</a> "'.get_entity($vars['entity']->form_id)->title.'"</p>';
	$info .= "<p class=\"owner_timestamp\"><a href=\"{$owner->getURL()}\">{$owner->name}</a> {$friendlytime}</p>";
	echo elgg_view_listing($icon,$info.$vars['annotations']);

?>