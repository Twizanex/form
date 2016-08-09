<?php

	/**
	 * Elgg display long text, no_p
	 * Displays a large amount of text, with new lines converted to line breaks
	 * 
	 * This version modified to remove paragraph wrapper and replace internal 
	 * paragraph tags with <br /><br />
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 * 
	 * @uses $vars['text'] The text to display
	 * 
	 */

	global $CONFIG;

    $value = trim(elgg_autop(parse_urls(filter_tags($vars['value']))));
    
    // strip off last </p> if any
    if (substr($value,strlen($value)-4,4) == '</p>') {
    	$value = substr($value,0,strlen($value)-4);
    }
    // eliminate <p> tags
    $value = str_replace('<p>','',$value);
    // replace </p> tags with <br /><br />
    $value = str_replace('</p>','<br /><br />',$value);
    
    echo $value;
    
?>
