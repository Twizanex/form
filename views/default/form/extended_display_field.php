<?php

/**
 * Form extended field display
 *
 * @package form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 */

	 $value = $vars['value'];
	 $title = $vars['title'];
	 
	 $body = <<<END
<label>$title<br />
<p>$value</p>
</label>
END;
    print $body;
?>