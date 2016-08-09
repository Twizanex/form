<?php
$form = $vars['form'];
$body = '<div class="contentWrapper">';
if (trim($form->response_text)) {
	$body .= '<p class="form-response">'.$form->response_text.'</p>';
} else {
	$body .= '<p class="form-response">'.elgg_echo('form:default_response_text').'</p>';
}
$body .= '</div>';
echo $body;
?>