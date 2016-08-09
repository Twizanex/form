<?php
$allselect = ''; $friendsselect = ''; $mineselect = '';
switch($vars['form_view']) {
	case 'all':		$allselect = 'class="selected"';
					break;
	case 'friends':		$friendsselect = 'class="selected"';
					break;
	case 'recommendations':		$recommendedselect = 'class="selected"';
					break;
	case 'mine':		$mineselect = 'class="selected"';
					break;
}

$url_start = $vars['url'].'mod/form/my_forms.php?id='.$vars['form_id'].'&amp;mode='.$vars['mode'];

?>
<div id="elgg_horizontal_tabbed_nav">
	<ul>
		<li <?php echo $allselect; ?> ><a onclick="javascript:$('#form_wrapper').load('<?php echo $url_start; ?>&amp;form_view=all&amp;callback=true'); return false;" href="<?php echo $url_start; ?>&amp;form_view=all&amp;callback=true"><?php echo elgg_echo('all'); ?></a></li>
		<?php if ($vars['enable_recommendations'])  {?>
			<li <?php echo $recommendedselect; ?> ><a onclick="javascript:$('#form_wrapper').load('<?php echo $url_start; ?>&amp;form_view=recommendations&amp;callback=true'); return false;" href="<?php echo $url_start; ?>&amp;form_view=recommendations&amp;callback=true"><?php echo elgg_echo('form:recommended'); ?></a></li>
		<?php } ?>
		<li <?php echo $friendsselect; ?> ><a onclick="javascript:$('#form_wrapper').load('<?php echo $url_start; ?>&amp;form_view=friends&amp;callback=true'); return false;" href="<?php echo $url_start; ?>&amp;form_view=friends&amp;callback=true"><?php echo elgg_echo('friends'); ?></a></li>
		<li <?php echo $mineselect; ?> ><a onclick="javascript:$('#form_wrapper').load('<?php echo $url_start; ?>&amp;form_view=mine&amp;callback=true'); return false;" href="<?php echo $url_start; ?>&amp;form_view=mine&amp;callback=true"><?php echo elgg_echo('mine'); ?></a></li>
	</ul>
</div>