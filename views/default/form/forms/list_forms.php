<?php
/*
 * Elgg Forms
 * Kevin Jardine
 * Radagast Solutions
 * http://radagast.biz
 *
 * Displays existing forms
 *
 */
 
 // load form model
	 require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/models/model.php");
 
//$title = elgg_echo('form:list_forms_title');   
    
$view_all_text = elgg_echo('form:view_all');

$form_template = <<<END
<div class="contentWrapper">
<h2>%s</h2>
<p>
%s
</p>
%s
<a href="{$CONFIG->wwwroot}mod/form/my_forms.php?id=%s&form_view=all">$view_all_text</a>
%s
</div>
END;

//$pg_owner_entity = elgg_get_page_owner_entity();
//$username = $pg_owner_entity->username;

$body = '';

$profile_form = form_get_latest_public_profile_form();

if ($profile_form) {
    $sd_list = elgg_get_entities_from_metadata('form_id',$profile_form->getGUID(),'object','form:search_definition');
    if ($sd_list) {
    	$body .= '<div class="contentWrapper">';
        $body .= '<h2>'.elgg_echo('form:profiles').'</h2><br />';
        foreach($sd_list as $sd) {
            $sd_id = $sd->getGUID();
            $body .= "<a href=\"{$vars['url']}mod/form/search.php?sid=$sd_id\">".form_search_definition_t($form,$sd,'title')."</a><br />";
        }
        $body .= '</div>';
    }
}    

$forms = elgg_get_entities_from_metadata('profile','0','object','form:form');
if ($forms) {
    foreach ($forms as $form) {
    	$form_id = $form->getGUID();
    	if (elgg_is_logged_in()) {
    		$add_bit = '<a href="'.$vars['url'].'mod/form/form.php?id='.$form_id.'">'.elgg_echo('form:add_content').'</a> | ';
    	} else {
    		$add_bit = '';
    	}
    	$sd_bit = '';
    	$sd_list = elgg_get_entities_from_metadata('form_id',$form_id,'object','form:search_definition');
        if ($sd_list) {
            foreach($sd_list as $sd) {
                $sd_id = $sd->getGUID();
                $sd_bit .= "| <a href=\"{$vars['url']}mod/form/search.php?sid=$sd_id\">".form_search_definition_t($form,$sd,'title')."</a>";
            }
        }
        $body .= sprintf($form_template,form_form_t($form,'title'),form_form_t($form,'listing_description'),$add_bit,$form_id,$sd_bit);      
    }
} else {
    if (!$profile_form) {
        $body .= '<p>'.elgg_echo('form:no_content').'</p>';
    }
}

print $body;
    
    
?>