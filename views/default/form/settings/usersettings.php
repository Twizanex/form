<?php
	/**
	 * User settings for forms.
	 * 
	 * @package Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 */
    $key = 'form:view_content_languages';
	$form_view_languages = $_SESSION['user']->$key;
	if ($form_view_languages) {
    	$form_view_languages = explode(",",$form_view_languages);
	} else {
    	$form_view_languages = array();
	}
	$languages = get_installed_translations();
?>
	<h3><?php echo elgg_echo('form:usersettings_title'); ?></h3>
	
	<p><?php echo elgg_echo('form:usersettings_description'); ?></p>
	
<?php
	echo elgg_view('form/input/checkboxes',array('internalname' => "form_view_language", 'options' => $languages, 'value' => $form_view_languages));

?>
