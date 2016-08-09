<?php
/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * Displays existing search definitions
 *
 */
     
$edit_msg = elgg_echo('form:edit'); 
$delete_msg = elgg_echo('form:delete');
$delete_confirm_msg = elgg_echo('form:search_definition_delete_confirm');
$search_page = elgg_echo('form:search_page_link');

$img_template = '<img border="0" width="16" height="16" alt="%s" title="%s" src="'.$CONFIG->wwwroot.'mod/form/images/%s" />';
$edit_img = sprintf($img_template,$edit_msg,$edit_msg,"16-em-pencil.png");
$delete_img = sprintf($img_template,$delete_msg,$delete_msg,"16-em-cross.png");
$tokens = form_add_security_fields();

$sd_template = <<<END
<a href="{$CONFIG->wwwroot}mod/form/manage_search_definition.php?sid=%s">$edit_img</a> |
<a onclick="return confirm('$delete_confirm_msg')" href="{$CONFIG->wwwroot}action/form/manage_search_definition?form_action=delete&sid=%s&$tokens">$delete_img</a> |
<a href="{$CONFIG->wwwroot}mod/form/search.php?sid=%s">$search_page</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s (%s)
<br />
END;

$body = '<div class="contentWrapper">';

$form_id = get_input('form_id',0);
$sds = elgg_get_entities_from_metadata('form_id',$form_id,'object','form:search_definition');
if ($sds) {
    foreach ($sds as $sd) {
        $ident = $sd->getGUID();
        $body .= sprintf($sd_template,$ident,$ident,$ident,$sd->title,$sd->internalname);
    }
} else {
    $body .= '<p>'.elgg_echo('form:no_search_definitions').'</p>';
}

$body .= '</div>';

print $body;    
    
?>