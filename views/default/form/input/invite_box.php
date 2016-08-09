<?php

	/**
	 * Elgg invite box view
	 * 
	 * @package Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 * 
	 * @uses $vars['internalname'] The internal name of the field
	 */
    
	 echo '<br /><b>'.elgg_echo('form:contacts').'</b><br />';
	echo elgg_view('form/input/smallbox',array('internalname'=>$vars['internalname'].'_contacts','value'=>''));
	echo '<br /><b>'.elgg_echo('form:message').'</b><br />';
	echo elgg_view('form/input/smallbox',array('internalname'=>$vars['internalname'].'_message','value'=>''));

?>