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
	 
	 $form_tabs = $vars['tab_data'];
	 $tab_data = $form_tabs['main'];
	 $form = $vars['form'];
	 $preview = $vars['preview'];
	 $form_data_id = $vars['form_data_id'];
	 
	 if (isset($vars['description'])) {
    	 $description = $vars['description'];
	 } else {
    	 $description = form_form_t($form,'description');
	 }
	 
	 if ($preview) {
    	 $body = '<div class="contentWrapper">'.elgg_echo('form:preview_description').'</div>';
	 } else {
    	 $body = '';
	 }
	 // TODO - add some intelligent way to determine the form enctype?
	 $body .= <<<END
<script type="text/javascript" src="{$vars['url']}mod/form/tabber/tabber.js"></script>
<link rel="stylesheet" href="{$vars['url']}mod/form/tabber/example.css" type="text/css" media="screen" />
<div class="contentWrapper">
$description
</div>
<div class="contentWrapper">
<form action="{$vars['url']}action/form/submit" method="post" enctype="multipart/form-data">
END;
	$body .= elgg_view('input/securitytoken');
    $body .= elgg_view('input/hidden',array('internalname'=>'form_id', 'value'=>$form->getGUID()));
    $body .= elgg_view('input/hidden',array('internalname'=>'preview', 'value'=>$preview));
    $body .= elgg_view('input/hidden',array('internalname'=>'form_data_id', 'value'=>$form_data_id));
    
    $count = count($tab_data);
    
    if ($count > 1) {
        $body .= '<div class="tabber">';
        $body .= '<div class="tabberloading" ></div>';
        foreach($tab_data as $tab => $html) {
            if ($html) {            
                $body .= "<div class=\"tabbertab\" title=\"$tab\">";
                $body .= $html;
                $body .= "</div>\n";
            }
            
        }
        $body .= '</div>';
    } else if ($count == 1) {
        // don't show tabs if there is only one
        foreach($tab_data as $tab => $html) {
            $body .= $html;
        }
    }
    
    $body .= $form_tabs['extra'];
                 
    $body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>elgg_echo('form:submit')));
    $body .= '</form></div>';
    print $body;
?>