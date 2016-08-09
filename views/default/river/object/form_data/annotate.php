<?php
	$performed_by = get_entity($vars['item']->subject_guid);
	$object = get_entity($vars['item']->object_guid);
	$form_title = get_entity($object->form_id)->title;
	
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string = '';
	$string .= sprintf(elgg_echo("form:river:commented"),$url) . " ";
	$string .= "<a href=\"" . $object->getURL() . "\">" . elgg_echo("form:river:this_content") . "</a> ".sprintf(elgg_echo("form:river:destination"),$form_title);

?>

<?php echo $string; ?>