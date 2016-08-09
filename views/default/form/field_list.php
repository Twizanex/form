<?php
$form_id = $vars['form_id'];
$profile = $vars['profile'];

$edit_msg = elgg_echo('form:edit');
$remove_msg = elgg_echo('form:remove');
$remove_confirm_msg = elgg_echo('form:remove_confirm');
$moveup_msg = elgg_echo('form:move_up');
$movedown_msg = elgg_echo('form:move_down');
$movetop_msg = elgg_echo('form:move_top');
$movebottom_msg = elgg_echo('form:move_bottom');

$img_template = '<img border="0" width="16" height="16" alt="%s" title="%s" src="'.$vars['config']->wwwroot.'mod/form/images/%s" />';
$edit_img = sprintf($img_template,$edit_msg,$edit_msg,"16-em-pencil.png");
$remove_img = sprintf($img_template,$remove_msg,$remove_msg,"16-em-cross.png");
$moveup_img = sprintf($img_template,$moveup_msg,$moveup_msg,"16-em-open.png");
$movedown_img = sprintf($img_template,$movedown_msg,$movedown_msg,"16-em-down.png");
$movetop_img = sprintf($img_template,$movetop_msg,$movetop_msg,"16-em-left.png");
$movebottom_img = sprintf($img_template,$movebottom_msg,$movebottom_msg,"16-em-right.png");
$tokens = form_add_security_fields();
$start_url = $vars['config']->wwwroot.'action/form/manage_field?form_action=move&id=%s&form_id=%s'.'&'.$tokens.'&direction=';
$link_template = '<a onclick="javascript:$(\'#field_list\').load(\'%s%s\'); return false;" href="%s%s">%s</a>';

$field_template = <<<END
<a href="{$vars['config']->wwwroot}action/form/manage_field?form_action=edit&id=%s&form_id=%s&$tokens&profile=$profile">$edit_img</a> |
<a onclick="return confirm('$remove_confirm_msg')" href="{$CONFIG->wwwroot}action/form/manage_field?form_action=remove&id=%s&form_id=%s&$tokens">$remove_img</a> |
%s |
%s |
%s |
%s
%s
<br />
END;

$fields = $vars['fields'];

if ($fields && count($fields) > 0 ) {
	foreach ($fields AS $field) {
		$ident = $field->getGUID();
		$url = sprintf($start_url,$ident,$form_id);
		$up = sprintf($link_template,$url,'up',$url,'up',$moveup_img);
		$down = sprintf($link_template,$url,'down',$url,'down',$movedown_img);
		$top = sprintf($link_template,$url,'top',$url,'top',$movetop_img);
		$bottom = sprintf($link_template,$url,'bottom',$url,'bottom',$movebottom_img);
		$field_list .= sprintf( $field_template,$ident,$form_id,$ident,$form_id,
		$up,$down,$top,$bottom,
		$field->title . ' ('.$field->internal_name.': '.$field->field_type.')');
	}
	$field_list .= '<br />';
} else {
	$field_list .= '<p>'.elgg_echo('form:none').'.</p>';
}

echo $field_list;
?>