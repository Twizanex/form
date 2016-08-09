<?php
/**
	 * Elgg form display
	 * Displays the specified Elgg form
	 * 
	 * @package Elgg
	 * @subpackage Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 */


// Load form model
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/models/model.php");

$form = $vars['entity'];

$tab_data = array();
$title = $form->title;
$maps = form_get_maps($form_id);
if ($maps) {
    foreach($maps as $map) {
        $field = get_entity($map->field_id);
        $vars = array('internalname'=>$field->internal_name,'value'=>$field->default_value);
        //print($field->internal_name.','.$field->field_type.','.$field->choice_type.','.$field->default_value.'<br />');
        if ($field->field_type == 'choices') {
            $vars['orientation'] = $field->orientation;
            $field_type = $field->choice_type;
            $choices = form_get_field_choices($field->getGUID());
            if ($choices) {
                if ($choices[0]->label) {
                    $options_values = array();
                    foreach($choices as $choice) {
                        $options_values[$choice->value] = $choice->label;
                    }
                    $vars['options_values'] = $options_values;
                } else {
                    $options = array();
                    foreach($choices as $choice) {
                        $options[$choice->value] = $choice->value;
                    }
                    $vars['options'] = $options;
                }
            }
                        
        } else {
            $field_type = $field->field_type;
        }
        $view = 'input/'.$field_type;
        if (in_array($field_type, array('radio','checkboxes'))) {
            // use the local view
            $view = 'form/'.$view;
        }
        //print($view.'<br />');
        if (!$field->tab) {
            $tab = elgg_echo('form:basic_tab_label');
        } else {
            // TODO - allow forms to get this data from the translation file rather than directly
            $tab = $field->tab;
        }
        
        if (!isset($tab_data[$tab])) {
            $tab_data[$tab] = '';
        }
        $tab_data[$tab] .= elgg_view('form/display_field', array('field'=>elgg_view($view,$vars),
            'title'=>$field->title,'description'=>$field->description));
    }
}
    
echo elgg_view('form/display_form', array('description'=>$form->description,'tab_data'=>$tab_data));

?>
