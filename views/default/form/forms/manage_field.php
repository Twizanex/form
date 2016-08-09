<?php

/**
 * Elgg manage field page
 * 
 * @package Form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 * @uses $vars['field'] The field to edit
 *       $vars['form_id'] The form to add a new field to
 *       $vars['new_field_name'] Optionally, an internal name for this field
 */

$form_field_types = form_get_form_field_types();

$i = 0;

foreach ($form_field_types as $type => $ft) {
	if ($type == 'contact') {
		$contact_index = $i;
	} else if ($type == 'choices') {
		$choices_index = $i;
	}
	$i += 1;
}

$form_id = $vars['form_id'];
$field = $vars['field'];
$choices = $vars['choices'];
$page_return_type = $vars['page_return_type'];
$new_field_name = $vars['new_field_name'];
$username = $vars['username'];

$profile_label = elgg_echo('form:profile_label');
$profile_description = elgg_echo('form:profile_description');
$yes = elgg_echo('form:yes');
$no = elgg_echo('form:no');

$profile_bit = <<<END
<label class="labelclass" for="profile">$profile_label</label>
<input type="radio" name="profile" value="0" onChange="vis();" %s> $no
<input type="radio" name="profile" value="1" onChange="vis();" %s> $yes
<p class="description">$profile_description</p>
END;

if (!isset($vars['profile'])) {
	if ($form_id) {
		$profile = get_entity($form_id)->profile;
	} else {
    	$profile = FORM_CONTENT;
	}
} else {
	$profile = $vars['profile'];
}

if (!$profile) {
	$profile = FORM_CONTENT;
}

// set up the field values

if ($field) {   
    if ($new_field_name) {
        // this is duplicating an existing field
        $form_action = 'add';
        $field_id = 0;
        $internal_name = $new_field_name;
    } else {
        $form_action = 'change';
        $field_id = $field->getGUID();
        $internal_name = $field->internal_name;
    }    
    
    $form_title = $field->title;
    $description = $field->description;
    $field_type = $field->field_type;
    
    // must do this because Elgg has trouble with metadata set to "0"
    // in Elgg 1.5
    $m = elgg_get_metadata($field->getGUID(),'default_access');
    if ($m) {
    	$default_access = $m->value;
	    if ($default_access !== '') {
	    	$field_access = (int) $default_access;
	    } else {
	    	$field_access = '';
	    }
    } else {
    	$field_access = '';
    }
    $default_value = $field->default_value;
    $is_keyword_tag = $field->is_keyword_tag;
    if (in_array($field_type,array('url','email','aim','msn','skype','icq'))) {
        $contact_type = $field_type;
        $field_type = 'contact';
        $contact_class = 'visible';
    } else {
        $contact_class = 'invisible';
        $contact_type = '';
    }
    
    if (isset($choices)) {
        $number_of_options = count($choices);
    } else {
        $number_of_options = 0;
    }
    
    if ($field_type == 'choices') {
        $choices_class = 'visible';
        if (($profile == 1) | ($profile == 2)) {
            $is_keyword_tag_class = 'visible';
        } else {
            $is_keyword_tag_class = 'invisible';
        }
            
    } else {
        $choices_class = 'invisible';
        $is_keyword_tag_class = 'invisible';
    }
    
    $required_no_checked = '';
    $required_yes_checked = '';
    if ($field->required) {
        $required_yes_checked = 'checked';
    } else {
        $required_no_checked = 'checked';
    }
    
    $admin_only_no_checked = '';
    $admin_only_yes_checked = '';
    if ($field->admin_only) {
        $admin_only_yes_checked = 'checked';
    } else {
        $admin_only_no_checked = 'checked';
    }
    
    $profile_no_checked = '';
    $profile_yes_checked = '';
    
    if (($profile == FORM_USER_PROFILE) || ($profile==FORM_GROUP_PROFILE)) {
        $profile_yes_checked = 'checked';
        $profile_class = 'visible';
    } else {
        $profile_no_checked = 'checked';
        $profile_class = 'invisible';
    }
    
    // remove this for now
    
    /*if ($profile_bit) {
         $profile_bit = sprintf($profile_bit, $profile_no_checked, $profile_yes_checked);
     }*/
    $profile_bit = '';
    
    $category = $field->tab;
    $subtype_filter = $field->subtype_filter;
    
    $invisible_no_checked = '';
    $invisible_yes_checked = '';
    if ($field->invisible) {
        $invisible_yes_checked = 'checked';
    } else {
        $invisible_no_checked = 'checked';
    }
    
    $is_keyword_tag_no_checked = '';
    $is_keyword_tag_yes_checked = '';
    if ($is_keyword_tag) {
        $is_keyword_tag_yes_checked = 'checked';
    } else {
        $is_keyword_tag_no_checked = 'checked';
    }
    
    // make this always invisible as it is not currently used  
    $is_keyword_tag_class = 'invisible';
    
    $area_left_checked = '';
    $area_right_checked = '';
    $area_bottom_checked = '';
    $area_no_checked = '';
    if ($field->area == 'left') {
        $area_left_checked = 'checked';
    } else if ($field->area == 'right') {
        $area_right_checked = 'checked';
    } else if ($field->area == 'bottom') {
        $area_bottom_checked = 'checked';
    } else {
        $area_no_checked = 'checked';
    }
    
    $choice_type_select_checked = '';
    $choice_type_radio_checked = '';
    $choice_type_radio_with_other_checked = '';
    $choice_type_checkbox_checked = '';
    if ($field->choice_type == 'pulldown') {
        $choice_type_select_checked = 'checked';
        $orientation_class = 'invisible';
    } else if ($field->choice_type == 'radio') {
        $choice_type_radio_checked = 'checked';
        $orientation_class = 'visible';
    } else if ($field->choice_type == 'radio_with_other') {
        $choice_type_radio_with_other_checked = 'checked';
        $orientation_class = 'visible';
    } else {
        $choice_type_checkbox_checked = 'checked';
        $orientation_class = 'visible';
    }
    
    $orientation_horizontal_checked = '';
    $orientation_vertical_checked = '';
    if ($field->orientation == 'horizontal') {
        $orientation_horizontal_checked = 'checked';
    } else {
        $orientation_vertical_checked = 'checked';
    }
    
} else {
    $form_action = 'add';
    
    $number_of_options = 0;
    //$profile = $vars['profile'];
    
    $orientation_class = 'invisible';
    $profile_class = 'invisible';
    $choices_class = 'invisible';
    $contact_class = 'invisible';
    $is_keyword_tag_class = 'invisible';
    
    $field_id = 0;
    
    $internal_name = $new_field_name;
    $form_title = '';
    $description = '';
    $field_type = 'profile_shorttext';
    $field_access = '';
    $contact_type = 'web';
    
    $default_value = '';
    $is_keyword_tag_no_checked = 'checked';
    $is_keyword_tag_yes_checked = '';  
    // make this always invisible as it is not currently used  
    $is_keyword_tag_class = 'invisible';
    
    $required_no_checked = 'checked';
    $required_yes_checked = '';
    
    $admin_only_no_checked = 'checked';
    $admin_only_yes_checked = '';
            
    $profile_no_checked = '';
    $profile_yes_checked = '';
    if (($profile == FORM_USER_PROFILE) || ($profile == FORM_GROUP_PROFILE)) {
        $profile_yes_checked = 'checked';
        $profile_class = 'visible';
    } else {
        $profile_no_checked = 'checked';
        $profile_class = 'invisible';
    }
    $profile_bit = '<input type="hidden" name="profile" value="'.$profile.'">';
    
    $category = '';
    $subtype_filter = '';
    
    $invisible_no_checked = 'checked';
    $invisible_yes_checked = '';
    
    $registration_no_checked = 'checked';
    $registration_yes_checked = '';
            
    $area_right_checked = 'checked';
    $area_left_checked = '';
    $area_bottom_checked = '';
    $area_no_checked = '';
    
    $choice_type_select_checked = 'checked';
    $choice_type_radio_checked = '';
    $choice_type_radio_with_other_checked = '';
    $choice_type_checkbox_checked = '';
    
    $orientation_horizontal_checked = 'checked';
    $orientation_vertical_checked = '';
}

// define the Javascript and CSS
    
$body = <<<END
<script>
number_of_options = $number_of_options;

function vis() {
    var x,v;
    // show profile config if relevant
    v = document.field_form.profile;
    x = document.getElementById('profile_config');
    /*if (v && v[1] && v[1].checked) {
        x.className = 'visible';
    } else {
        x.className = 'invisible';
    }*/
    
    // hack to make this always visible for now
    profile = $profile;
    if ((profile == 1) || (profile == 2)) {
        x.className = 'visible';
    } else {
        x.className = 'invisible';
    }
    
    // show choice config if relevant
    //u = document.field_form.profile;
    v = document.field_form.field_type;
    x = document.getElementById('choices_config');
    y = document.getElementById('contact_config');
    z = document.getElementById('is_keyword_tag_config');
    z.className = 'invisible';
    if (v.options[$choices_index].selected) {
        x.className = 'visible';
        y.className = 'invisible';
        //if (u[1].checked) {
        //    z.className = 'visible';
        //}
    } else if (v.options[$contact_index].selected) {
        x.className = 'invisible';
        y.className = 'visible';        
    } else {
        x.className = 'invisible';
        y.className = 'invisible';
    }    
    
    // show orientation config if relevant
    v = document.field_form.choice_type;
    x = document.getElementById('orientation_config');
    if (v[1].checked || v[2].checked) {
        x.className = 'visible';
    } else {
        x.className = 'invisible';
    }         
}

function add_option() {
    var o,el;
    o = document.getElementById('option_container');
    el = document.createElement('input');
    el.type = 'text';
    el.className = "option_value_input";
    el.name = "option_"+number_of_options+"_value";
    el.value = "";
    o.appendChild(el);
    el = document.createElement('input');
    el.type = 'text';
    el.className = "option_label_input";
    el.name = "option_"+number_of_options+"_label";
    el.value = "";
    o.appendChild(el);
    el = document.createElement('br');
    o.appendChild(el);
    number_of_options++;
    document.field_form.number_of_options.value = number_of_options;
    
    x = document.getElementById('option_outer_container');
    x.className = 'visible';
}    
</script>
<style>
div.invisible {
    display: none;
}
div.visibleright {
    float:right;
    width: 100px;
}

label.labelclass {
    display:block;
    font-weight:bold;
}

p.description {
    font-size: 0.9em;
    margin-top: 0px;
}

span.option_value_header {
    font-weight: bold;
    width: 150px;
    display: block;
    float: left;
}

span.option_label_header {
    font-weight: bold;
    width: 300px;
    margin-left: 10px;
}

input.option_value_input {
    width:150px;
}

input.option_label_input {
    margin-left:10px;
    width:300px;
}

input.standard {   
    width: 100%;
}

input.longer {
    width:100%;
} 
</style>
END;

print $body;

// define a whole lot of text

$horizontal = elgg_echo('form:horizontal');
$vertical = elgg_echo('form:vertical');

if ($form_action == 'add') {
    $title = elgg_echo('form:add_field_title');
    $form_description = elgg_echo('form:add_field_description');
} else {
    $title = elgg_echo('form:manage_field_title');
    $form_description = elgg_echo('form:manage_field_description');
}    

$internal_name_label = elgg_echo('form:internal_name_label');
$internal_name_description = elgg_echo('form:internal_name_description');

$title_label = elgg_echo('form:title_label');
$title_description = elgg_echo('form:title_description');

$description_label = elgg_echo('form:description_label');
$description_description = elgg_echo('form:description_description');

$required_label = elgg_echo('form:required_label');
$required_description = elgg_echo('form:required_description');

$admin_only_label = elgg_echo('form:admin_only_label');
$admin_only_description = elgg_echo('form:admin_only_description');

$field_type_label = elgg_echo('form:field_type_label');

$profile_config_title = elgg_echo('form:profile_config_title');

$category_label = elgg_echo('form:category_label');
$category_description = elgg_echo('form:category_description');

$subtype_label = elgg_echo('form:subtype_label');
$subtype_description = elgg_echo('form:subtype_description');

$invisible_label = elgg_echo('form:invisible_label');

$invisible_description = elgg_echo('form:invisible_description');

$registration_label = elgg_echo('form:registration_label');

$registration_description = elgg_echo('form:registration_description');

$column_label = elgg_echo('form:column_label');

$column_description = elgg_echo('form:column_description');

$choice_header = elgg_echo('form:choice_header');

$choice_field_type_label = elgg_echo('form:choice_field_type_label');
$choice_field_type_description = elgg_echo('form:choice_field_type_description');

$dropdown = elgg_echo('form:dropdown');
$radio = elgg_echo('form:radio');
$radio_with_other = elgg_echo('form:radio_with_other');
$checkbox = elgg_echo('form:checkbox');

$default_value_label = elgg_echo('form:default_value_label');
$default_value_description = elgg_echo('form:default_value_description');

$is_keyword_tag_label = elgg_echo('form:is_keyword_tag_label');
$is_keyword_tag_description = elgg_echo('form:is_keyword_tag_description');

$orientation_label = elgg_echo('form:orientation_label');
$orientation_description = elgg_echo('form:orientation_description');

$access_label = elgg_echo('form:access_label');
$access_description = elgg_echo('form:access_description');

$options_header = elgg_echo('form:options_header');
$options_value_header = elgg_echo('form:options_value_header');
$options_label_header = elgg_echo('form:options_label_header');
$options_description = elgg_echo('form:options_description');
$options_add_button = elgg_echo('form:options_add_button');

$profile_left = elgg_echo('form:profile_left');
$profile_right = elgg_echo('form:profile_right');
$profile_bottom = elgg_echo('form:profile_bottom');

// set up some form components

if ($form_action == "add") {
    $manage_field_button = elgg_echo('form:add_field_button');
} else {
    $manage_field_button = elgg_echo('form:change_field_button');
}

$this_form_link_text = elgg_echo('form:this_form_link_text');
$form_link_text = elgg_echo('form:form_link_text');
$field_link_text = elgg_echo('form:field_link_text');

// TODO: the following code shows the admin's access list. 
// Try to find something more generic.

$access_options = get_write_access_array();
$access_options[''] = elgg_echo('form:use_system_default_access');

/*$access_options = array(
    '' => elgg_echo('form:use_system_default_access'),
    'PRIVATE' => elgg_echo('ACCESS_PRIVATE'),
    'PUBLIC' => elgg_echo('ACCESS_PUBLIC'),
    'LOGGED_IN' => elgg_echo('ACCESS_LOGGED_IN'),
);*/

$access = '<select name="default_access">'."\n";
foreach ($access_options as $value => $label) {
    if ($value === $field_access) {
        $selected = 'selected';
    } else {
        $selected = '';
    }
    $access .= sprintf('<option value="%s" %s>%s</option>'."\n", $value, $selected, $label);
}
    
$access .= '</select>'."\n";

$field_type_select = '<select name="field_type" onChange="vis();">'."\n";

foreach ($form_field_types as $value => $ft) {
    if ($value == $field_type) {
        $selected = 'selected';
    } else {
        $selected = '';
    }
    $field_type_select .= sprintf('<option value="%s" %s>%s</option>'."\n", $value, $selected, $ft->label);
}
    
$field_type_select .= '</select>'."\n";

$contact_options = array(
    'url' => elgg_echo("form:url"),
    'email' => elgg_echo("form:email"),
    'aim' => elgg_echo("form:aim"),
    'msn' => elgg_echo("form:msn"),
    'skype' => elgg_echo("form:skype"),
    'icq' => elgg_echo("form:icq"),
);

$contact_radio = '';

foreach ($contact_options as $value => $label) {
    if ($value == $contact_type) {
        $checked = 'checked';
    } else {
        $checked = '';
    }
    $contact_radio .= sprintf('<input type="radio" name="contact_type" value="%s" %s /> %s'."\n", $value, $checked, $label);
}

$option_template = '<input class="option_value_input" type="text" name="option_%s_value" value="%s">';
$option_template .= '<input class="option_label_input" type="text" name="option_%s_label" value="%s">';
$option_template .= "<br />\n";

$options_bit = '';

if ($number_of_options > 0) {
    $count = 0;
    foreach($choices AS $option) {
        $options_bit .= sprintf($option_template,$count,$option->value,$count,$option->label);
        $count ++;
    }
}

if ($profile != FORM_FILE) {
	$required_bit = <<<END
	<label class="labelclass" for="required">$required_label</label>
<input type="radio" name="required" value="0" $required_no_checked> $no
<input type="radio" name="required" value="1" $required_yes_checked> $yes
<p class="description">$required_description</p>
END;
} else {
	$required_bit = '';
}

if ($profile != FORM_REGISTRATION) {
	$admin_bit = <<<END
	<label class="labelclass" for="admin_only">$admin_only_label</label>
<input type="radio" name="admin_only" value="0" $admin_only_no_checked> $no
<input type="radio" name="admin_only" value="1" $admin_only_yes_checked> $yes
<p class="description">$admin_only_description</p>
END;
} else {
	$admin_bit = '<input type="hidden" name="admin_only" value="'.$field->admin_only.'">';
}

// define the form

$security_token = elgg_view('input/securitytoken');

$body = <<< END
<div class="contentWrapper">
<p>$form_description</p>
<form name="field_form" action="{$CONFIG->wwwroot}action/form/manage_field" method="post">
<input type="hidden" name="form_action" value="$form_action">
<input type="hidden" name="form_id" value="$form_id">
<input type="hidden" name="field_id" value="$field_id">
<input type="hidden" name="number_of_options" value="$number_of_options">
<input type="hidden" name="type" value="$page_return_type">
<input type="hidden" name="username" value="$username">
$security_token
<label class="labelclass" for="internal_name">$internal_name_label</label>
<input type="text" class="standard" name="internal_name" value="$internal_name">
<p class="description">$internal_name_description</p>
<label class="labelclass" for="title">$title_label</label>
<input type="text" class="standard" name="title" value="$form_title">
<p class="description">$title_description</p>
<label class="labelclass" for="description">$description_label</label>
<input type="text" class="longer" name="description" value="$description">
<p class="description">$description_description</p>
<label class="labelclass" for="default_value">$default_value_label</label>
<input type="text" class="standard" name="default_value" value="$default_value">
<p class="description">$default_value_description</p>
$required_bit
$admin_bit
<label class="labelclass" for="category">$category_label</label>
<input type="text" class="standard" name="category" value="$category">
<p class="description">$category_description</p>
$profile_bit
<label class="labelclass" for="field_type">$field_type_label</label>
$field_type_select
<div id="contact_config" class="$contact_class">
    $contact_radio
</div>
<div id="choices_config" class="$choices_class">
    <br />
    <h1>$choice_header</h1>
    <label class="labelclass" for="choice_type">$choice_field_type_label</label>
    <input type="radio" name="choice_type" onChange="javascript:vis();" value="pulldown" $choice_type_select_checked> $dropdown
    <input type="radio" name="choice_type" onChange="javascript:vis();" value="radio" $choice_type_radio_checked> $radio
    <input type="radio" name="choice_type" onChange="javascript:vis();" value="radio_with_other" $choice_type_radio_with_other_checked> $radio_with_other
    <input type="radio" name="choice_type" onChange="javascript:vis();" value="checkboxes" $choice_type_checkbox_checked> $checkbox
    <p class="description">$choice_field_type_description</p>
    <div id="is_keyword_tag_config" class="$is_keyword_tag_class">
        <label class="labelclass" for="is_keyword_tag">$is_keyword_tag_label</label>
        <input type="radio" name="is_keyword_tag" value="0" $is_keyword_tag_no_checked> $no
        <input type="radio" name="is_keyword_tag" value="1" $is_keyword_tag_yes_checked> $yes
        <p class="description">$is_keyword_tag_description</p>
    </div>
    <div id="orientation_config" class="$orientation_class">
        <label class="labelclass" for="orientation">$orientation_label</label>
        <input type="radio" name="orientation" value="horizontal" $orientation_horizontal_checked> $horizontal
        <input type="radio" name="orientation" value="vertical" $orientation_vertical_checked> $vertical
        <p class="description">$orientation_description</p>
    </div>
    <div id="option_outer_container" class="$choices_class">
        <div id="option_container">
            <h1>$options_header</h1>
            <span class="option_value_header">$options_value_header</span>
            <span class="option_label_header">$options_label_header</span>
            <br />
            $options_bit
            <br />
        </div>
        <p class="description">$options_description</p>
    </div>
    
    <br />
    <input type="button" name="option_button" value="$options_add_button"  onClick="add_option();">
</div>
<div id="profile_config" class="$profile_class">
    <br />
    <h1>$profile_config_title</h1>
    <br />
    <label class="labelclass" for="invisible">$invisible_label</label>
    <input type="radio" name="invisible" value="0" $invisible_no_checked> $no
    <input type="radio" name="invisible" value="1" $invisible_yes_checked> $yes
    <p class="description">$invisible_description</p>
    <label class="labelclass" for="area">$column_label</label>
    <input type="radio" name="area" value="left" $area_left_checked> $profile_left
    <input type="radio" name="area" value="right" $area_right_checked> $profile_right
    <input type="radio" name="area" value="bottom" $area_bottom_checked> $profile_bottom
    <input type="radio" name="area" value="" $area_no_checked> $no
    <p class="description">$column_description</p>
    <label class="labelclass" for="default_access">$access_label</label>
    $access
    <p class="description">$access_description</p>
</div>
<br />
<input type="submit" value="$manage_field_button" />
</form>
</div>
END;

echo $body;

?>
