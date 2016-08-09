<?php

// TODO - make this into a JS form that sends messages
// via the message_queue plugin
$fd = $vars['fd'];
$sd = $vars['sd'];
$body = '<h2>'.elgg_echo('form:search_messaging:send_to').'</h2><br />';
$body .= elgg_view('input/hidden',array('internalname'=>'sid','value'=>$sd->guid));
foreach($fd as $key => $value) {
	if (is_array($value)) {
		$value = implode(",",$value);
	}
	$body .= elgg_view('input/hidden',array('internalname'=>'form_data_'.$key,'value'=>$value));
}

$body .= '<p><label>'.elgg_echo('form:search_messaging:subject_label').'</label><br />';
$body .= elgg_view('input/text',array('internalname'=>'message_subject'));
$body .= '</p><br />';

$body .= '<p><label>'.elgg_echo('form:search_messaging:body_label').'</label><br />';
$body .= elgg_view('form/input/longtext',array('internalname'=>'message_body'));
$body .= '</p><br />';

$body .= elgg_view('input/submit',array('value'=>elgg_echo('form:search_messaging:send')));
$body .= '&nbsp;';
$body .= elgg_view('input/button',array('internalid'=>'cancel_send','value'=>elgg_echo('form:search_messaging:cancel')));

$form = elgg_view('input/form',array('internalid'=>'search_send_form','body'=>$body,'action'=>$vars['url'].'action/form/send_search_message'));
?>
<p id="send_response"></p>
<div id="form_send_container" style="display:none;">
<?php echo $form ?>
</div>
<?php echo elgg_view('input/button',array('internalid'=>'open_send','value'=>elgg_echo('form:search_messaging:send_to'))) ?>
<script type="text/javascript">
$('#cancel_send').click(function() {
	$('#form_send_container').hide();
	$('#open_send').show();
	return false;
});
$('#open_send').click(function() {
	$('#form_send_container').show();
	$('#open_send').hide();
});
// bind form and provide a callback function 
$('#search_send_form').ajaxForm(function(response) {
	$('#send_response').html(response);
	$('#form_send_container').hide();
	$('#open_send').show();
});
</script>