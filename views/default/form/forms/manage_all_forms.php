<?php
/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * Displays existing forms
 *
 */
 
$title = elgg_echo('form:list_forms_title');   
    
$edit_msg = elgg_echo('form:edit'); 
$delete_msg = elgg_echo('form:delete');
$delete_confirm_msg = elgg_echo('form:form_delete_confirm');

$img_template = '<img border="0" width="16" height="16" alt="%s" title="%s" src="'.$CONFIG->wwwroot.'mod/form/images/%s" />';
$edit_img = sprintf($img_template,$edit_msg,$edit_msg,"16-em-pencil.png");
$delete_img = sprintf($img_template,$delete_msg,$delete_msg,"16-em-cross.png");
$export_text = elgg_echo('form:export');
$preview_text = elgg_echo('form:preview');
$link_text = elgg_echo('form:link');
$tokens = form_add_security_fields();

$form_template = <<<END
<a href="{$CONFIG->wwwroot}mod/form/manage_form.php?id=%s">$edit_img</a> |
<a onclick="return confirm('$delete_confirm_msg')" href="{$CONFIG->wwwroot}action/form/manage_form?form_action=delete&id=%s&$tokens">$delete_img</a> |
<a href="{$CONFIG->wwwroot}mod/form/form.php?id=%s&preview=true">$preview_text</a> |
<a href="{$CONFIG->wwwroot}mod/form/form.php?id=%s">$link_text</a>
&nbsp;&nbsp;&nbsp;%s
<br />
END;

$body = '<div class="contentWrapper">';

/*$user_content_status = form_get_user_content_status();
$body .= '<h2>'.elgg_echo('form:user_content_status_title').'</h2><br />';

$options = array(   1=>elgg_echo('form:yes'),
0=>elgg_echo('form:no') );

$body .= '<form action="'.$CONFIG->wwwroot.'action/form/manage_form" method ="post" >';
$body .= elgg_view('input/hidden',array('internalname'=>'form_action', 'value'=>'user_content_status'));

$body .= elgg_view('form/input/radio',array('internalname'=>'user_content_status','options'=>$options,'value'=>$user_content_status));

$body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>elgg_echo('form:submit')));
$body .= '</form>';*/

$body .= '<h2>'.elgg_echo('form:form_list').'</h2><br />';

$forms = elgg_get_entities('object','form:form',0,"",1000);
if ($forms) {
    foreach ($forms as $form) {
        $ident = $form->getGUID();
        $body .= sprintf($form_template,$ident,$ident,$ident,$ident,$form->title.' ('.$form->name.')');
    }
} else {
    $body .= '<p>'.elgg_echo('form:no_forms').'</p>';
}

$body .= '</div>';

echo $body;
    
    
?>