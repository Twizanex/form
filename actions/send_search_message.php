<?php
$sid = get_input('sid');
$subject = get_input('message_subject');
$body = get_input('message_body');
$sd = get_entity($sid);
$fd = form_get_data_from_form_submit($sd->form_id);
// supports mailing up to 10 thousand people
// although this large a number probably would not work in practice
$result = form_get_data_with_search_conditions($fd,$sd,10000,0);
$count = $result[0];
$entities = $result[1];
if ($count > 0) {
	$message = message_queue_create_message($subject,$body);
	if ($message) {
		$message_id = $message->guid;
		foreach($entities as $user) {
			message_queue_add($message_id,$user->guid);
		}
		$response = sprintf(elgg_echo('form:search_send_response'),$count);
	} else {
		$response = elgg_echo('form:search_send_error');
	}
} else {
	$response = elgg_echo('form:search_send_error');
}
echo $response;
end;
?>