<?php

/**
    * Elgg display missing error
    * 
    * @package Elgg
    * @subpackage Form
    * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
    * @author Kevin Jardine <kevin@radagast.biz>
    * @copyright Radagast Solutions 2008
    * @link http://radagast.biz/
    */
    
    $missing = $vars['missing'];
    $tabs = array();
    foreach($missing as $field) {
        // order within tab
        if (!isset($tabs[$field->tab])) {
            $tabs[$field->tab] = array();
        }
        $tabs[$field->tab][] = $field->title;
    }
    
    $field_list = array();
    
    foreach ($tabs as $tab => $fields) {
    	if (!$tab) {
    		$tab = elgg_echo('form:basic_tab_label');
    	}
        $field_list[] = implode(', ',$fields).' '.sprintf(elgg_echo('form:tab_bit'),$tab);
    }      
    
    print sprintf(elgg_echo('form:error_missing_fields'),implode('; ',$field_list));
?>