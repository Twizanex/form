<?php

/**
 * Manage group categories
 * 
 * @package Elgg
 * @subpackage Form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 */
	 
$group_profile_categories = $vars['group_profile_categories'];

$body .= '<div class="contentWrapper">';

$body .= '<p class="form-description">'.elgg_echo('form:manage_group_profile_categories_description').'</p>';
                    
$body .= '<form action="'.$CONFIG->wwwroot.'action/form/manage_form" method ="post" >';
// security token
$body .= elgg_view('input/securitytoken');
$body .= elgg_view('input/hidden',array('internalname'=>'form_action', 'value'=>'manage_group_profile_categories'));

$body .= elgg_view('form/input/longtext',array('internalname'=>'group_profile_categories','value'=>$group_profile_categories));

$body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>elgg_echo('form:submit')));
$body .= '</form>';

$body .= '</div>';

echo $body;

?>