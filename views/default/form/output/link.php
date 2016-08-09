<?php

	/**
	 * Elgg link display
	 */

    $val = trim($vars['href']);
    if (!empty($val)) {
	    if ((substr_count($val, "http://") == 0) && (substr_count($val, "https://") == 0)) {
	        $val = "http://" . $val;
	    }
	    
	    if ($vars['is_action'])
		{
			$ts = time();
			$token = generate_action_token($ts);
	    	
	    	$sep = "?";
			if (strpos($val, '?')>0) $sep = "&";
			$val = "$val{$sep}__elgg_token=$token&__elgg_ts=$ts";
		}
	    
	    echo "<a href=\"{$val}\" target=\"_blank\">". htmlentities($vars['text'], ENT_QUOTES, 'UTF-8'). "</a>";
    }

?>
