<?php

/**
 * Default form data display
 * 
 * @package form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2009
 * @link http://radagast.biz/
 */

$form_data_id = $vars['entity']->getGUID();
$data = form_get_data($form_data_id);
$form = get_entity($vars['entity']->form_id);
$tab_data = form_get_tabbed_output_display($form,$data);
echo elgg_view('form/forms/display_form_content',array('tab_data'=>$tab_data,'description'=>'','preview'=>0,'form'=>$form,'form_data_id'=>0));
echo $vars['annotations'];
?>