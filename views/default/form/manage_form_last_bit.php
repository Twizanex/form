<?php
$form = $vars['form'];
$type_options = form_type_options();
$yn_options = array(elgg_echo('form:yes')=>'yes',
	elgg_echo('form:no')=>'no',
);

if ($form) {
	$listing_description = $form->listing_description;
    $response_text = $form->response_text;
    if ($form->allow_comments) {
        $allow_comments = 1;
    } else {
    	$allow_comments = 0;
    }
    if ($form->allow_recommendations) {
        $allow_recommendations = 1;
    } else {
    	$allow_recommendations = 0;
    }
    if ($form->email_form) {
        $email_form = 1;
    } else {
    	$email_form = 0;
    }
    $email_to = $form->email_to;
    
	if ($form->enable_display_menu) {
        $enable_display_menu = 1;
    } else {
    	$enable_display_menu = 0;
    }    
    $display_menu_title = $form->display_menu_title;
    
	if ($form->enable_create_menu) {
        $enable_create_menu = 1;
    } else {
    	$enable_create_menu = 0;
    }
    $create_menu_title = $form->create_menu_title;
	if(!$form->show_profile_access) {
    	$show_profile_access = 'yes';
    } else {
    	$show_profile_access = $form->show_profile_access;
    }
    
    $profile = $form->profile;
    if ($form->profile_format) {
    	$profile_format = $form->profile_format;
    } else {
    	$profile_format = 'default';
    }
    $search_box_fields = $form->search_box_fields;      
} else {
	$listing_description = '';
    $response_text = '';
    $allow_comments = 0;
    $email_form = 0;
    $email_to = '';
    $enable_display_menu = 0;
    $display_menu_title = '';
    $enable_create_menu = 0;
    $create_menu_title = '';
    $allow_recommendations = 0;
    $profile_format = 'default';
    $search_box_fields = '';
}

$last_bit = '';
if ($form) {
	$last_bit .= '<div class="tabbertab" title="'.elgg_echo('form:last_bit_tab_label').'">';
}

if (($profile == FORM_USER_PROFILE) || ($profile == FORM_GROUP_PROFILE)) {
	$format_options = array(
		elgg_echo('form:profile_format_default_option_label') => 'default',
		elgg_echo('form:profile_format_no_extended_option_label') => 'no_extended',
		elgg_echo('form:profile_format_tabbed_option_label') => 'tabbed',
	);
	
	if ($profile == FORM_GROUP_PROFILE) {
		$format_options[elgg_echo('form:profile_format_wide_tabbed_option_label')] = 'wide_tabbed';
	}

	if ($form) {
		$last_bit .= '<input type="hidden" name="response_text" value="">';
		 
		$last_bit .= '<label class="labelclass" for="profile_format">'.elgg_echo('form:profile_format_label').'</label><br />';
		$last_bit .= elgg_view('input/radio', array('internalname'=>'profile_format','value'=>$profile_format,'options'=>$format_options));
		$last_bit .= '<p class="description">'.elgg_echo('form:profile_format_description').'</p>';

		$last_bit .= '<label class="labelclass" for="profile_category">'.elgg_echo('form:profile_category_label').'</label>';
		$last_bit .= elgg_view('input/text',array('internalname'=>'profile_category','value'=>trim($form->profile_category)));
		$last_bit .= '<p class="description">'.elgg_echo('form:profile_category_description').'</p>';
		
		if ($profile == FORM_USER_PROFILE) {
			$last_bit .= '<label class="labelclass" for="show_profile_access">'.elgg_echo('form:show_profile_access_label').'</label><br />';
			$last_bit .= elgg_view('input/radio',array('value'=>$show_profile_access,'internalname'=>'show_profile_access','options'=>$yn_options));
			$last_bit .= '<p class="description">'.elgg_echo('form:show_profile_access_description').'</p>';
		}
	}
} else if ($profile == FORM_CONTENT) {
	// content form stuff
	if ($form) {
		
		// search box fields
		$last_bit .= '<label class="labelclass" for="search_box_fields">'.elgg_echo('form:search_box_fields_label').'</label>';
		$last_bit .= elgg_view('input/text', array('internalname'=>'search_box_fields','value'=>$search_box_fields));
		$last_bit .= '<p class="description">'.elgg_echo('form:search_box_fields_description').'</p>';
		
		// form listing description
		$last_bit .= '<label class="labelclass" for="form_listing_description">'.elgg_echo('form:listing_description_label').'</label>';
		$last_bit .= elgg_view('form/input/longtext',array('internalname'=>'form_listing_description','value'=>$listing_description));
		$last_bit .= '<p class="description">'.elgg_echo('form:form_listing_description').'</p>';

		// response text
	  
		$last_bit .= '<label class="labelclass" for="response_text">'.elgg_echo('form:response_text_label').'</label>';
		$last_bit .= elgg_view('form/input/longtext',array('internalname'=>'response_text','value'=>$response_text));
		$last_bit .= '<p class="description">'.elgg_echo('form:response_description').'</p>';

		// email form option
		
		$last_bit .= '<br /><br />';

		$last_bit .= elgg_view('input/checkboxes',array('internalname'=>'email_form','value'=>$email_form, 'options'=>array(elgg_echo('form:email_form_label')=>1)));
		$last_bit .= '<p>'.elgg_echo('form:email_form_description').'</p>';

		$last_bit .= '<label class="labelclass" for="email_to">'.elgg_echo('form:email_to_label').'</label>';
		$last_bit .= elgg_view('input/text', array('internalname'=>'email_to','value'=>$email_to));
		$last_bit .= '<p class="description">'.elgg_echo('form:email_to_description').'</p>';
		
		$last_bit .= '<br /><br />';
		
		// display menu option

		$last_bit .= elgg_view('input/checkboxes',array('internalname'=>'enable_display_menu','value'=>$enable_display_menu, 'options'=>array(elgg_echo('form:enable_display_menu_label')=>1)));
		$last_bit .= '<p>'.elgg_echo('form:enable_display_menu_description').'</p>';

		$last_bit .= '<label class="labelclass" for="display_menu_title">'.elgg_echo('form:display_menu_title_label').'</label>';
		$last_bit .= elgg_view('input/text', array('internalname'=>'display_menu_title','value'=>$display_menu_title));
		$last_bit .= '<p class="description">'.elgg_echo('form:display_menu_title_description').'</p>';
		
		$last_bit .= '<br /><br />';
		
		// create menu option

		$last_bit .= elgg_view('input/checkboxes',array('internalname'=>'enable_create_menu','value'=>$enable_create_menu, 'options'=>array(elgg_echo('form:enable_create_menu_label')=>1)));
		$last_bit .= '<p>'.elgg_echo('form:enable_create_menu_description').'</p>';
		
		$last_bit .= '<label class="labelclass" for="create_menu_title">'.elgg_echo('form:create_menu_title_label').'</label>';
		$last_bit .= elgg_view('input/text', array('internalname'=>'create_menu_title','value'=>$create_menu_title));
		$last_bit .= '<p class="description">'.elgg_echo('form:create_menu_title_description').'</p>';
		
		$last_bit .= '<br /><br />';

		// comment and recommendation options

		$last_bit .= '<p>';
		$last_bit .= elgg_view('input/checkboxes',array('internalname'=>'allow_comments','value'=>$allow_comments, 'options'=>array(elgg_echo('form:allow_comments_label')=>1)));
		$last_bit .= elgg_view('input/checkboxes',array('internalname'=>'allow_recommendations','value'=>$allow_recommendations, 'options'=>array(elgg_echo('form:allow_recommendations_label')=>1)));
		$last_bit .= '</p>';
	}

}

if ($form) {
	$last_bit .= '<input type="submit"  name="submit" value="'.elgg_echo('form:form_manage_button').'">';
	$last_bit .= '</div>';
}

echo $last_bit;
?>