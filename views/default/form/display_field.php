<?php

/**
	 * Elgg field display
	 * Displays the specified Elgg title, field and description
	 * 
	 * @package Elgg
	 * @subpackage Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 */
	 
	 $field = $vars['field'];
	 $title = $vars['title'];
	 $description = $vars['description'];
	 
	 $body = <<<END
<label>$title</label><br />
$field
<p class="form-field-description">$description</p>
END;
    print $body;
?>