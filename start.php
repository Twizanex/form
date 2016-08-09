<?php

	/**
	 * Elgg form plugin
	 * 
	 * @package Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 */

	// Load form model
    require_once(dirname(__FILE__)."/models/model.php");

	/**
	 * Form initialisation
	 *
	 * These parameters are required for the event API, but we won't use them:
	 * 
	 * @param unknown_type $event
	 * @param unknown_type $object_type
	 * @param unknown_type $object
	 */
    
	function form_init() {
		
		// Load system configuration
			global $CONFIG;
			
		// Load the language files
			//register_translations($CONFIG->pluginspath . "form/languages/");
			register_translations($CONFIG->pluginspath . "form/languages/formtrans/");
			
		// Register entity type
			if (elgg_get_plugin_setting('register_user_content', 'form') == 'yes') {
				elgg_register_entity_type('object','form_data');
			}
			
		// Register a page handler, so we can have nice URLs
			elgg_register_page_handler('form','form_page_handler');
		
		elgg_register_plugin_hook_handler('usersettings:save','user','form_user_settings_save');
		
		// Register a URL handler for form data
		elgg_register_entity_url_handler('form_data_url','object','form_data');
		
		elgg_extend_view('css','form/css');
		
		// must register subtypes to avoid elgg_get_entities bug (returns all entities if one is not defined)
		// in Elgg 1.6.1 and below

		add_subtype('object', 'form:form');
		add_subtype('object', 'form:config');
		add_subtype('object', 'form:field');
		add_subtype('object', 'form:field_map');
		add_subtype('object', 'form:field_choice');
		add_subtype('object', 'form:search_definition');
		add_subtype('object', 'form_data');
		
	}
	
	function form_pagesetup() {
		global $CONFIG;
		
		// Set up menu and content setting for logged in users
		if (elgg_is_logged_in()) {			
			form_set_menu_items();    		
    		if (form_get_user_content_status()) {
			
			    elgg_register_menu_item(elgg_echo('item:object:form_data'), $CONFIG->wwwroot . "pg/form/" . $_SESSION['user']->username);
			    // add a view content option to user settings
		        extend_elgg_settings_page('form/settings/usersettings', 'usersettings/user');
		    }
		}

		$context = elgg_get_context();
		
		if (in_array($context,array('form','form:content','form:admin'))) {
		
			$form_id = get_input('form_id',get_input('id',0));
			if (!$form_id && ($sid = get_input('sid',0))) {
				$form_id = get_entity($sid)->form_id;
			}
			if ($form_id) {
				$form = get_entity($form_id);
				elgg_set_page_owner_guid($form->getOwner());
			}
		}
		
		if (elgg_get_page_owner_entity()) {
			$username = elgg_get_page_owner_entity()->username;
		}
		
		if ($context == 'admin') {
			$admin_url = $CONFIG->wwwroot.'mod/form/manage_all_forms.php';
			if ($username) {
				$admin_url .= '?username='.$username;
			}
			elgg_register_menu_item(elgg_echo('form:manage_forms_title'),$admin_url);
		}
		
		if ($context == 'form:admin' && elgg_is_admin_logged_in()) {
	       // elgg_register_menu_item(elgg_echo('form:add_new_profile_form_link'),$CONFIG->wwwroot.'mod/form/manage_form.php?username='.$username.'&profile=1', '4formactions');
	       // elgg_register_menu_item(elgg_echo('form:add_new_group_profile_form_link'),$CONFIG->wwwroot.'mod/form/manage_form.php?username='.$username.'&profile=2', '4formactions');
	        elgg_register_menu_item(elgg_echo('form:manage_group_profile_categories_title'),$CONFIG->wwwroot.'mod/form/manage_group_profile_categories.php?username='.$username, '4formactions');
		}
		
		if (in_array($context,array('form','form:content','form:admin')) && elgg_is_admin_logged_in()) {
			// currently only admins get to manage forms
			if ($form_id) {
				elgg_register_menu_item(elgg_echo('form:edit_page_link'),$CONFIG->wwwroot.'mod/form/manage_form.php?id='.$form_id,'1formactions');
				if ($context == 'form:admin') {
						elgg_register_menu_item(elgg_echo('form:preview_link_text'),$CONFIG->wwwroot.'mod/form/form.php?id='.$form_id.'&preview=true', '1formactions');
						elgg_register_menu_item(elgg_echo('form:public_link_text'),$CONFIG->wwwroot.'mod/form/form.php?id='.$form_id, '1formactions');
						elgg_register_menu_item(elgg_echo('form:list_search_definitions_link'),$CONFIG->wwwroot.'mod/form/list_search_definitions.php?form_id='.$form_id, '1formactions');
						elgg_register_menu_item(elgg_echo('form:add_new_search_definition_link_text'),$CONFIG->wwwroot.'mod/form/manage_search_definition.php?form_id='.$form_id, '1formactions');
						elgg_register_menu_item(elgg_echo('form:manage_translations_link'),$CONFIG->wwwroot.'mod/form/manage_form_translation.php?id='.$form_id, '1formactions');
				}
			}
		
			elgg_register_menu_item(elgg_echo('form:manage_forms_title'),$CONFIG->wwwroot.'mod/form/manage_all_forms.php?username='.$username, '3formactions');
			if ($context == 'form:admin') {
				elgg_register_menu_item(elgg_echo('form:add_new_link'),$CONFIG->wwwroot.'mod/form/manage_form.php?username='.$username, '4formactions');
            	elgg_register_menu_item(elgg_echo('form:list_all_fields_link'),$CONFIG->wwwroot.'mod/form/list_fields.php?type=all&username='.$username, '3formactions');
				elgg_register_menu_item(elgg_echo('form:list_orphan_fields_link'),$CONFIG->wwwroot.'mod/form/list_fields.php?type=orphan&username='.$username, '3formactions');
			}			
		}
		if (in_array($context,array('form','form:content','form:admin')) && (form_get_user_content_status())) {
			elgg_register_menu_item(elgg_echo('form:view_all_forms'),$CONFIG->wwwroot.'pg/form/'.$username, '2formactions');
		}
		
		if ($context == 'form:content' && $form_id) {
			if (elgg_is_logged_in()) {
				elgg_set_page_owner_guid($_SESSION['user']->getGUID());
			}
			if (!$form->profile) {
				if ($sid = get_input('sid',0)) {
					$sid_bit = '&sid='.$sid;
				} else {
					$sid_bit = '';
				}
				if (elgg_is_logged_in()) {
					elgg_register_menu_item(elgg_echo('form:add_content'),$CONFIG->wwwroot.'mod/form/form.php?id='.$form_id,'0formactions');
					//elgg_register_menu_item(elgg_echo('form:view_mine'),$CONFIG->wwwroot.'mod/form/my_forms.php?id='.$form_id.'&form_view=mine'.$sid_bit,'4formactions');
					//elgg_register_menu_item(elgg_echo('form:view_friends'),$CONFIG->wwwroot.'mod/form/my_forms.php?id='.$form_id.'&form_view=friends'.$sid_bit,'4formactions');
				}
				elgg_register_menu_item(elgg_echo('form:view_all'),$CONFIG->wwwroot.'mod/form/my_forms.php?id='.$form_id.'&form_view=all'.$sid_bit,'0formactions');
				$sd_list = elgg_get_entities_from_metadata('form_id',$form_id,'object','form:search_definition');
			    if ($sd_list) {
			        foreach($sd_list as $sd) {
			            $sd_id = $sd->getGUID();
			            elgg_register_menu_item(form_search_definition_t($form,$sd,'title'),$CONFIG->wwwroot.'mod/form/search.php?sid='.$sd_id,'0formactions');
			        }
			    }
			}
		}
	}
	
	/**
	 * Form page handler; allows the use of fancy URLs
	 *
	 * @param array $page From the page_handler function
	 * @return true|false Depending on success
	 */
	function form_page_handler($page) {
		
		// The first component of a form URL is the username
		if (isset($page[0])) {
			set_input('username',$page[0]);
		}
		
		@include(dirname(__FILE__) . "/index.php");
		return true;
		
	}
	
	function form_data_url($form_data) {
    	global $CONFIG;
    	
    	if (isset($_SESSION['last_search_qs'])) {
    		$url = $CONFIG->wwwroot.'mod/form/display_search_object.php?d='.$form_data->getGUID();	
    	    $url .= '&'.$_SESSION['last_search_qs'];
	    //} else if (isset($_SESSION['last_view_qs'])) {
	    //	$url = $CONFIG->wwwroot.'mod/form/my_forms.php?'.$_SESSION['last_view_qs'];
	    } else {
	    	$url = $CONFIG->wwwroot.'mod/form/display_object.php?d='.$form_data->getGUID();
	    }
	    
	    return $url;
	}
	
	function form_user_settings_save() {
    	$form_view_language = get_input('form_view_language',array());
    	gatekeeper();
    	
		$user = elgg_get_page_owner_entity();
    	if (!$user) {    	
    		$user = $_SESSION['user'];
    	}
    	
    	$result = false;
    	if (is_array($form_view_language)) {
    	    $languages = implode(',',$form_view_language);
    	    $setting_key = "form:view_content_languages";
			if ($user->$setting_key != $languages) {
    	    	$result = form_set_user_setting($user->getGUID(), $languages);
				if ($result) {
		    		system_message(elgg_echo('form:usersettings:save:ok'));
			    } else {
		    		register_error(elgg_echo('form:usersettings:save:fail'));
		    	}
			}
	    }
	}
	
	/**
	 * Set a form user pref.
	 *
	 * @param int $user_guid The user id.
	 * @param string $value.
	 * @return bool
	 */
	function form_set_user_setting($user_guid, $value)
	{
		$user_guid = (int)$user_guid;

		if ($user_guid == 0) 
			$user_guid = $_SESSION['user']->guid;
			
		$user = get_entity($user_guid);
		
		if (($user) && ($user instanceof ElggUser))
		{			
			$setting_key = "form:view_content_languages";
			$user->$setting_key = $value;
			$user->save();
		
			return true;
		}
			
		return false;
	}
	
// Make sure the form event functions are called
	elgg_register_event_handler('init','system','form_init');
	elgg_register_event_handler('pagesetup','system','form_pagesetup');
	
// Register actions
	global $CONFIG;
	elgg_register_action("form/send_search_message",false,$CONFIG->pluginspath . "form/actions/send_search_message.php");
	elgg_register_action("form/manage_form",false,$CONFIG->pluginspath . "form/actions/manage_form.php");
	elgg_register_action("form/manage_field",false,$CONFIG->pluginspath . "form/actions/manage_field.php");
	elgg_register_action("form/manage_search_definition",false,$CONFIG->pluginspath . "form/actions/manage_search_definition.php");
	elgg_register_action("form/submit",true,$CONFIG->pluginspath . "form/actions/submit.php");
	elgg_register_action("form/manage_form_data",true,$CONFIG->pluginspath . "form/actions/manage_form_data.php");
?>
