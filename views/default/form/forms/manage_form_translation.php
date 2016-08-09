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
$form_id = $form->getGUID();

if ($form->translate) {
    $translate = 1;
} else {
    $translate = 0;
}

echo '<div class="contentWrapper">';

echo '<p class="form-description">'.elgg_echo('form:translate_description').'</p>';

echo '</div>';

echo '<div class="contentWrapper">';

echo '<h2>'.elgg_echo('form:translation_status_title').'</h2><br />';

$options = array(   0=>elgg_echo('form:text_from_database'),
                    1=>elgg_echo('form:use_translation_system') );
                    
$body = '<form action="'.$CONFIG->wwwroot.'action/form/manage_form" method ="post" >';
// security token
$body .= elgg_view('input/securitytoken');
$body .= elgg_view('input/hidden',array('internalname'=>'id', 'value'=>$form->getGUID()));
$body .= elgg_view('input/hidden',array('internalname'=>'form_action', 'value'=>'translate_status'));

$body .= elgg_view('form/input/radio',array('internalname'=>'translate','options'=>$options,'value'=>$translate));

$body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>elgg_echo('form:submit')));
$body .= '</form>';

$body .= '</div>';

echo $body;

echo '<div class="contentWrapper">';

echo '<h2>'.elgg_echo('form:translation_content_title').'</h2><br />';

echo '<p class="form-description">'.elgg_echo('form:translate_content_description').'</p>';

echo '<textarea style="width:100%; height:250px;">';    

if ($form) {
    echo '\'form:formtrans:'.$form->name.':title\' => "'.htmlspecialchars($form->title).'",'."\n";
    if ($form->description)
    	echo '\'form:formtrans:'.$form->name.':description\' => "'.htmlspecialchars($form->description).'",'."\n";
    if ($form->listing_description)
    	echo '\'form:formtrans:'.$form->name.':listing_description\' => "'.htmlspecialchars($form->listing_description).'",'."\n";
    if ($form->response_text)
    	echo '\'form:formtrans:'.$form->name.':response_text\' => "'.htmlspecialchars($form->response_text).'",'."\n";
    $tabs = array();
    $fields = $vars['fields'];
    if ($fields && count($fields) > 0 ) {
        foreach ($fields AS $field) {
            $field_id = $field->getGUID();
            echo '\'form:fieldtrans:'.$field->internal_name.':title\' => "'.htmlspecialchars($field->title).'",'."\n";
            if ($field->description)
            	echo '\'form:fieldtrans:'.$field->internal_name.':description\' => "'.htmlspecialchars($field->description).'",'."\n";
            if ($field->field_type == 'choices') {
                $choices = form_get_field_choices($field_id);
                if ($choices) {
                    foreach($choices as $choice) {
                        echo '\'form:fieldchoicetrans:'.$field->internal_name.':'.$choice->value.'\' => "'.htmlspecialchars($choice->label).'",'."\n";
                    }
                }
            }
            
            if ($field->tab && !in_array($field->tab,$tabs)) {
                $tabs[] = $field->tab;
            }
            
        }
    }
    $sd_list = elgg_get_entities_from_metadata('form_id',$form_id,'object','form:search_definition');
    if ($sd_list) {
        foreach($sd_list as $sd) {
            echo '\'form:sdtrans:'.$form->name.':'.$sd->internalname.':title\' => "'.htmlspecialchars($sd->title).'",'."\n";
            echo '\'form:sdtrans:'.$form->name.':'.$sd->internalname.':description\' => "'.htmlspecialchars($sd->description).'",'."\n";
        }
    }
}

echo '</textarea>';

if (count($tabs) > 0) {
    echo '<br /><br /><p class="form-description">'.elgg_echo('form:tabs_translate_description').'</p>';
    echo '<textarea style="width:100%; height:100px;">'; 
    foreach ($tabs as $tab) {
        echo '\'form:tabtrans:'.$tab.'\' => "'.$tab.'",'."\n";
    } 
    echo '</textarea>';
}

echo '</div>';

?>