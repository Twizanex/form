<?php

	/**
	 * Elgg manage form view
	 * 
	 * @package Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 * 
	 * @uses $vars['form'] Optionally, the form to edit
	 */
	 
$form = $vars['form'];
$username = $vars['form_username'];

$profile = $vars['profile'];

if ($form) {
	if ($form->profile) {
    	$profile = $form->profile;
	} else {
		$profile = 0;
	}
}
    
$type_options = form_type_options();

if ($form) {
    $form_action = 'change';
    $explanation = elgg_echo('form:form_manage_description');
    $form_manage_button = elgg_echo('form:form_manage_button');
    $form_id = $form->getGUID();
    $form_name = $form->name;
    $form_title = $form->title;
    $description = $form->description;
    $access_id = $form->access_id;
    $field_list = elgg_view('form/field_list',array('fields' => $vars['fields'],'form_id' => $form_id, 'profile' => $profile));
        
    if (($profile == FORM_CONTENT) || ($profile == FORM_FILE) || ($profile == FORM_REGISTRATION)) {
    	// this bit is just for data, file or registration forms
        $display_bit = elgg_view('form/display_templates',array('form'=>$form));
    } else {
        $display_bit = '';
    }   
    
    $buttons = elgg_view('form/forms/field_adders',array('form_id'=>$form_id,'profile'=>$profile));
    $basic_tab = elgg_echo('form:basic_tab_label');
    $tab_bit= <<<END
<script type="text/javascript" src="{$vars['url']}mod/form/tabber/tabber.js"></script>
<link rel="stylesheet" href="{$vars['url']}mod/form/tabber/example.css" type="text/css" media="screen" />
<div class="tabber">
<div class="tabberloading" ></div>
<div class="tabbertab" title="$basic_tab">
END;
} else {
    $form_action = 'add';
    $manage_form_title = '';
    $explanation = elgg_echo('form:create_form_description');
    $form_manage_button = elgg_echo('form:create_form_button');
    $form_id = 0;
    $form_name = '';
    $form_title = '';
    $description = '';
    $access_id = ACCESS_PRIVATE;
    $display_bit = '';
    $field_list = '';
    $buttons = '';
    $tab_bit = '';
}

// top of form

$body = <<<END
<div class="contentWrapper">
<p>$explanation</p>
$tab_bit
<form action="{$vars['config']->wwwroot}action/form/manage_form" method="post">
<h1>$manage_form_title</h1>
<input type="hidden" name="form_id" value="$form_id">
<input type="hidden" name="form_action" value="$form_action">
<input type="hidden" name="username" value="$username">
END;

// security token
$body .= elgg_view('input/securitytoken');

// form name
$body .= '<label class="labelclass" for="form_name">'.elgg_echo('form:name_label').'</label>';
$body .= elgg_view('input/text',array('internalname'=>'form_name','value'=>$form_name));
$body .= '<p class="description">'.elgg_echo('form:name_description').'</p>';

// form title
$body .= '<label class="labelclass" for="form_title">'.elgg_echo('form:title_label').'</label>';
$body .= elgg_view('input/text',array('internalname'=>'form_title','value'=>$form_title));
$body .= '<p class="description">'.elgg_echo('form:form_title_description').'</p>';

// form content creation description
$body .= '<label class="labelclass" for="description">'.elgg_echo('form:description_label').'</label>';
$body .= elgg_view('form/input/longtext',array('internalname'=>'description','value'=>$description));
$body .= '<p class="description">'.elgg_echo('form:form_description_description').'</p>';

// form type
$body .= '<label class="labelclass" for="form_type">'.elgg_echo('form:type_label').'</label> ';
$body .= elgg_view('input/pulldown',array('internalname'=>'profile','options_values'=>$type_options,'value'=>$profile));
$body .= '<p class="description">'.elgg_echo('form:type_description').'</p>';

// access levels

$body .= '<label class="labelclass" for="access">'.elgg_echo('form:form_access_label').'</label>';
$body .= elgg_view('input/access', array('internalname' => 'access_id','value' => $access_id));
$body .= '<p class="description">'.elgg_echo('form:form_access_description').'</p>';


if ($form) {
	$body .= '<input type="submit"  name="submit" value="'.$form_manage_button.'">';
	$body .= '</div>';
}
if ($profile != 3) {
	// file forms don't use this
	$body .= elgg_view('form/manage_form_last_bit',array('form'=>$form));
}
$body .= $display_bit;

if ($form) {
	$body .= '</form>';
	$body .= $buttons;
	$body .= '<div class="tabbertab" title="'.elgg_echo('form:field_list_tab_label').'">';
	$body .= '<h2>'.elgg_echo('form:current_fields').'</h2><br />';
	$body .= '<div id="field_list">';
	$body .= $field_list;
	$body .= '</div>';
	$body .= '</div>';
} else  {
	$body .= '<input type="submit"  name="submit" value="'.$form_manage_button.'">';
	$body .= '</form>';
}
// bottom of form
$body .= <<<END
</div>
END;

if ($form) {
	$body .= '</div>';
}

print $body;

?>