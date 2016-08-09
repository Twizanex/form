<div class="sidebarBox">
<h3><?php echo elgg_echo('form:search'); ?></h3>
<form id="memberssearchform" action="<?php echo $vars['url']; ?>mod/form/search_box_results.php?" method="get">
	<input type="text" name="tag" value="" class="search_input" />
	<input type="hidden" name="id" value="<?php echo $vars['form_id']; ?>" />	
	<input type="submit" value="<?php echo elgg_echo('go'); ?>" />
</form>
</div>