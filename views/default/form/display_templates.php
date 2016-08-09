<?php

//TODO: support form templates for content forms as well
$form = $vars['form'];
$display_bit = '<div class="tabbertab" title="'.elgg_echo('form:display_templates_tab_label').'">';

if ($form->profile == FORM_REGISTRATION) {
	$display_bit .= '<label for="form_template">'.elgg_echo('form:form_template_label');
	$display_bit .= elgg_view('form/input/longtext',array('internalname'=>'form_template','value'=>$form->form_template));
	$display_bit .= '</label>';
	$display_bit .= '<p class="description">'.elgg_echo('form:form_template_description').'</p>';
} else {
	$display_bit .= '<label for="list_template">'.elgg_echo('form:list_template_label');
	$display_bit .= elgg_view('form/input/longtext',array('internalname'=>'list_template','value'=>$form->list_template));
	$display_bit .= '</label>';
	$display_bit .= '<p class="description">'.elgg_echo('form:list_template_description').'</p>';
	
	$display_bit .= '<label for="display_template">'.elgg_echo('form:display_template_label');
	$display_bit .= elgg_view('form/input/longtext',array('internalname'=>'display_template','value'=>$form->display_template));
	$display_bit .= '</label>';
	$display_bit .= '<p class="description">'.elgg_echo('form:display_template_description').'</p>';
}
$display_bit .= '<input type="submit"  name="submit" value="'.elgg_echo('form:form_manage_button').'">';
$display_bit .= '</div>';

echo $display_bit;
?>