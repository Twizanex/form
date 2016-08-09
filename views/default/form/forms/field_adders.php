<?php
/* buttons and links:
 *
 * preview form (link)
 * add existing field (input box for field name)
 * copy existing field (copies field definition) (input boxes for field name)
 * add new field (input box for field name)
 */

$form_id = $vars['form_id'];
$profile = $vars['profile'];

//TODO: clean this up

$add_existing_button = elgg_echo('form:add_existing_button');
$add_existing_field_description = elgg_echo('form:add_existing_field_description');
$copy_existing_button = elgg_echo('form:copy_existing_button');
$copy_existing_field_description = elgg_echo('form:copy_existing_field_description');
$add_new_button = elgg_echo('form:add_new_button');
$add_new_description = elgg_echo('form:add_new_description');
$existing_label = elgg_echo('form:existing_label');
$new_label = elgg_echo('form:new_label');
 
$add_fields_title = elgg_echo('form:add_fields_title');
$add_existing_title = elgg_echo('form:add_existing_title');
$copy_existing_title = elgg_echo('form:copy_existing_title');
$add_new_title =  elgg_echo('form:add_new_title');

$tokens = elgg_view('input/securitytoken');

$field_adders_tab = elgg_echo('form:field_adders_tab_label');
 
$buttons = <<<END
<div class="tabbertab" title="$field_adders_tab">
<form action="{$vars['url']}action/form/manage_field" method="post">
$tokens
<input type="hidden" name="form_id" value="$form_id">
<input type="hidden" name="form_action" value="add_new">
<input type="hidden" name="profile" value="$profile">
<label class="labelclass" for="new_field_name">$new_label</label>
END;

$buttons .= elgg_view('input/text',array('internalname'=>'new_field_name'));

$buttons .= <<<END
<br />
<span class="description">$add_new_description<br />
<input type="submit" name="submit" value="$add_new_button"></span>
</form>
<br />
<form action="{$vars['url']}action/form/manage_field" method="post">
$tokens
<input type="hidden" name="form_id" value="$form_id">
<input type="hidden" name="form_action" value="add_existing">
<input type="hidden" name="profile" value="$profile">
<label class="labelclass" for="existing_field_name">$existing_label</label>
END;

$buttons .= elgg_view('input/text',array('internalname'=>'existing_field_name'));

$buttons .= <<<END
<br />
<span class="description">$add_existing_field_description<br />
<input type="submit" name="submit" value="$add_existing_button"></span>
</form>
<form action="{$vars['url']}action/form/manage_field" method="post">
$tokens
<input type="hidden" name="form_id" value="$form_id">
<input type="hidden" name="form_action" value="copy_existing">
<input type="hidden" name="profile" value="$profile">
<label class="labelclass" for="existing_field_name">$existing_label</label>
END;

$buttons .= elgg_view('input/text',array('internalname'=>'existing_field_name'));

$buttons .= <<<END
<label class="labelclass" for="new_field_name">$new_label</label>
END;

$buttons .= elgg_view('input/text',array('internalname'=>'new_field_name'));

$buttons .= <<<END
<p class="description">$copy_existing_field_description<br />
<input type="submit" name="submit" value="$copy_existing_button"></p>
</form>
</div>
END;

echo $buttons;
?>