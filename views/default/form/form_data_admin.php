<?php
$tokens = form_add_security_fields();
$manage_bit = '<div class="form-manage">';
$manage_bit .= '<a href="'.$vars['url'].'mod/form/form.php?id='.$vars['form_id'].'&d='.$vars['form_data_id'].'">';
$manage_bit .= elgg_echo('form:edit');
$manage_bit .= '</a> | ';
$manage_bit .= '<a onclick="return confirm(\''.elgg_echo('form:content_delete_confirm').'\')" ';
$manage_bit .= 'href="'.$vars['url'].'action/form/manage_form_data?form_action=delete&d='.$vars['form_data_id'].'&'.$tokens.'">';
$manage_bit .= elgg_echo('form:delete');
$manage_bit .= '</a>';
$manage_bit .= '</div><br />';

echo $manage_bit;
?>