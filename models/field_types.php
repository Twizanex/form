<?php
$form_field_types = array(
    'shorttext' => (object) array(
		'label'			=>	elgg_echo('form:profile_shorttext_label'),
		'input_view' 	=> 'form/input/shorttext',
		'output_view' 	=> 'output/text'
		),
    'text' => (object) array(
		'label'			=>	elgg_echo('form:profile_text_label'),
		'input_view' 	=> 'input/text',
		'output_view' 	=> 'output/text'
		),
    'smallbox' => (object) array(
		'label'			=>	elgg_echo('form:profile_smallbox_label'),
		'input_view' 	=> 'form/input/smallbox',
		'output_view' 	=> 'output/longtext'
		),
    'longtext' => (object) array(
		'label'			=> elgg_echo('form:profile_longtext_label'),		
		'input_view' 	=> 'input/longtext',
		'output_view' 	=> 'output/longtext'
		),
	'smallbox_no_p' => (object) array(
		'label'			=>	elgg_echo('form:profile_smallbox_no_p_label'),
		'input_view' 	=> 'form/input/smallbox',
		'output_view' 	=> 'form/output/longtext_no_p'
		),
    'longtext_no_p' => (object) array(
		'label'			=> elgg_echo('form:profile_longtext_no_p_label'),		
		'input_view' 	=> 'input/longtext',
		'output_view' 	=> 'form/output/longtext_no_p'
		),
    'calendar' => (object) array(
		'label'			=> elgg_echo('form:profile_calendar_label'),
		'input_view' 	=> 'input/calendar',
		'output_view' 	=> 'output/calendar'
		),
    'tags' => (object) array(
		'label'			=> elgg_echo('form:profile_keywords_label'),
		'input_view' 	=> 'input/tags',
		'output_view' 	=> 'form/output/tags'
		),
    'image_upload' => (object) array(
		'label'			=> elgg_echo('form:profile_image_label'),		
		'input_view' 	=> 'input/file',
		'output_view' 	=> 'form/output/image'
		),
    'video_box' => (object) array(
		'label'			=> elgg_echo('form:profile_video_box_label'),
		'input_view' 	=> 'input/text',
		'output_view' 	=> 'form/output/video_box'
		),
    'invite_box' => (object) array(
		'label'			=> elgg_echo('form:profile_invite_box_label'),
		'input_view' 	=> 'form/input/invite_box',
		'output_view' 	=> ''
		),
    'access' => (object) array(
		'label'			=> elgg_echo('form:profile_access_label'),
		'input_view' 	=> 'input/access',
		'output_view' 	=> 'output/access'
		),
	'group_category' => (object) array(
		'label'			=> elgg_echo('form:group_category_dropdown'),
		'input_view' 	=> 'form/input/group_categories',
		'output_view' 	=> 'form/output/choice'
		),
	// contacts and choices get special handling
    'contact' => (object) array(
		'label'			=> elgg_echo('form:profile_contact_label'),
		'input_view' 	=> '',
		'output_view' 	=> ''
		),
    'choices' => (object) array(
		'label'			=> elgg_echo('form:profile_choices_label'),
		'input_view' 	=> '',
		'output_view' 	=> ''
		),
);

?>