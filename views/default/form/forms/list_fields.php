<?php

	/**
	 * Elgg list fields view
	 * 
	 * @package Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 * 
	 * @uses $vars['form'] Optionally, the form to edit
	 */

$type = $vars['page_return_type'];
$fields = $vars['fields'];
$username = $vars['user']->username;
    
$edit_msg = elgg_echo('form:edit');;
$delete_msg = elgg_echo('form:delete');
$delete_orphans_confirm_msg = elgg_echo('form:orphan_delete_all_confirm');
if ($type == 'orphan') {
    $delete_confirm_msg = elgg_echo('form:orphan_delete_confirm');
} else {
    $delete_confirm_msg = elgg_echo('form:field_delete_confirm');
}

$img_template = '<img border="0" width="16" height="16" alt="%s" title="%s" src="'.$CONFIG->wwwroot.'mod/form/images/%s" />';
$edit_img = sprintf($img_template,$edit_msg,$edit_msg,"16-em-pencil.png");
$delete_img = sprintf($img_template,$delete_msg,$delete_msg,"16-em-cross.png");
$tokens = form_add_security_fields();

$field_template = <<<END
<a href="{$CONFIG->wwwroot}action/form/manage_field?form_action=edit_with_field_id&id=%s&type=%s&username=$username&$tokens">$edit_img</a> |
<a onclick="return confirm('$delete_confirm_msg')" href="{$CONFIG->wwwroot}action/form/manage_field?form_action=delete&id=%s&type=%s&username=$username&$tokens">$delete_img</a>
&nbsp;&nbsp;&nbsp;%s
<br />
END;

$body .= '<div class="contentWrapper">';
if ($type == 'orphan') {
	$body .= '<p><b><a onclick="return confirm(\''.$delete_orphans_confirm_msg.'\')" href="'.$CONFIG->wwwroot.'action/form/manage_field?form_action=delete_orphans&username='.$username.'&'.$tokens.'">'.elgg_echo('form:delete_orphans').'</a></b></p> '."\n";
    $body .= '<p>'.elgg_echo('form:orphan_list_description').'</p>'."\n";
} else {
    $body .= '<p>'.elgg_echo('form:field_list_description').'</p>'."\n";
}

if ($fields) {
    foreach ($fields as $field) {
        $field_id = $field->getGUID();
        $body .= sprintf(
            $field_template,
            $field_id,
            $type,
            $field_id,
            $type,
            $field->title . ' ('.$field->internal_name.': '.$field->field_type.')');
    }
} else {
    $body .= '<p>'.elgg_echo('form:no_fields').'</p>';
}
$body .= '</div>';
print $body;

?>