<?php

/**
 * Elgg form profile model
 * Functions to manage user and group profile data
 * 
 * @package Elgg
 * @subpackage Form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 */

require_once(dirname(__FILE__).'/model.php');
// Profile data is stored as metadata on the user or group entity

function form_get_latest_public_profile_form($profile_type=1,$profile_category='') {
	$conditions = array('profile'=>$profile_type, 'profile_category'=>$profile_category);
    $form_array = elgg_get_entities_from_metadata($conditions,'object','form:form');
    if (!$form_array) {
    	if ($profile_category) {
    		// try again, this time with an empty (default) profile category
    		$profile_category = '';
    		$conditions = array('profile'=>$profile_type, 'profile_category'=>'');
    		$form_array = elgg_get_entities_from_metadata($conditions,'object','form:form');
    	}
    }
    
    if ($form_array) {
    	// return the first public form
    	// need to check for profile_category because sadly 
    	// get_entities_from_metadata_multi does not work properly for empty strings
    	foreach($form_array as $form) {
            if (((!$profile_category && !$form->profile_category) || ($form->profile_category == $profile_category))) {
                return $form;
            }
        }
    }
    
    return null;
}

function form_get_group_profile_categories() {
    $form_config = elgg_get_entities('object','form:config');
    if ($form_config) {
        return $form_config[0]->group_profile_categories;
    }
    return '';
}

function form_set_group_profile_categories($group_profile_categories) {
	$form_config = elgg_get_entities('object','form:config');
    if (!$form_config) {
        $form_config = new ElggObject();
        $form_config->subtype = 'form:config';
        $form_config->owner_guid = $_SESSION['user']->getGUID();
        $form_config->access_id = ACCESS_PUBLIC;
    } else {
        $form_config = $form_config[0];
    }
    
    $form_config->group_profile_categories = $group_profile_categories;
    $form_config->save();
}

function form_get_data_from_profile($form_id,$entity) {
    $metadata = elgg_get_metadata($entity->getGUID());
    
    // beginning of workaround
    // sadly Elgg 1.1 fails to enforce access controls for get_metadata_for_entity
    // see http://trac.elgg.org/elgg/ticket/531
    // so I need to do this dance to workaround this
    $good_metadata = array();
    if ($metadata) {
    	foreach($metadata as $m) {
    		// get_metadata does enforce the access controls, so use that
    		$good_m = elgg_get_metadata_from_id($m->id);
    		if ($good_m) {
    			$good_metadata[] = $good_m;
    		}
    	}    	
    }
    $metadata = $good_metadata;
    // end of workaround
    
    $data = array();
    $fields = form_get_fields($form_id);
    if ($fields) {
        foreach($fields as $field) {
        	$internalname = $field->internal_name;
        	// not too efficient but the metadata doesn't seem to be keyed
        	foreach($metadata as $m) {
        		// set an array if there are multiple metadata items with the same name
        		// otherwise a single value
        		// currently only the tags and checkbox groups fields return multiple values
        		if ($m->name == $internalname) {
        			if (!isset($data[$internalname])) {
        				$data[$internalname] = new StdClass();
        				$data[$internalname]->value = $m->value;
        			} else if (is_array($data[$internalname]->value)) {
        				$data[$internalname]->value[] = $m->value;
        			} else {
            			$data[$internalname]->value = array($data[$internalname]->value,$m->value);
        			}
            		$data[$internalname]->access_id = $m->access_id;     			
        		}
        	}           
        }
    }
    return $data;
}

// use the specified profile form to return the data (indexed by summary area) from the specified user or group entity

function form_get_data_for_profile_summary_display($form, $entity) {
    $form_id = $form->getGUID();
    $data = form_get_data_from_profile($form_id,$entity);
    $area_data = array();
    $maps = form_get_maps($form_id);
    if ($maps) {
        foreach($maps as $map) {
            $field = get_entity($map->field_id);
            $internalname = $field->internal_name;
            if (isset($data[$internalname]) && $data[$internalname]->value) {
                $area = $field->area;
                if ($area) {
                    if (!isset($area_data[$area])) {
                        $area_data[$area] = array();
                    }
                    $item = new StdClass();
                    $item->internalname = $internalname;
                    $item->title = form_field_t($form,$field,'title');
                    $item->description = form_field_t($form,$field,'description');
                    $item->value = form_get_field_output($form,$field,$data[$internalname]->value);
                    $area_data[$area][] = $item;
                }
            }
        }
    }
    return $area_data;
}

// use the specified profile form to return the data (indexed by tab) from the specified user or group entity

function form_get_data_for_profile_tabbed_display($form, $entity) {
    $form_id = $form->getGUID();
    $data = form_get_data_from_profile($form_id,$entity);
    return form_get_tabbed_output_display($form,$data);
}
    

// Return the form fields (indexed by tab), 
// prepopulated with the data (if supplied) or 
// from the specified user or group entity.

function form_get_data_for_profile_edit_form($form, $entity=null, $group_profile_category='',$data=null) {

	if (!isset($data)) {
	    if ($entity) {
	        $data = form_get_data_from_profile($form->getGUID(),$entity);
	    } else {
	    	if ($group_profile_category) {
		    	$item = new stdClass;
		    	$item->name = 'group_profile_category';
		    	$item->value = $group_profile_category;
		        $data = array('group_profile_category'=>$item);
	    	}
	    }
	}
    
    $tab_data = array();
    $form_tabs = form_display_by_tab($form,$data,true);
    $tabs = $form_tabs['main'];
    if ($tabs) {
        foreach ($tabs as $tab => $tab_items) {
            $tab_data[$tab] = '';
            foreach ($tab_items as $item) {
            	if ($entity instanceof ElggUser) {
	    			// add access control pulldowns
	                $internalname = $item->internalname;
	                if (isset($data[$internalname])) {
	                    $access_id = $data[$internalname]->access_id;                
	                } else {
	                    if ($item->default_access || $item->default_access === 0) {
	                        $access_id = $item->default_access;
	                    } else {
	                        $access_id = get_default_access();
	                    }	                
            		}            	
	                $access_bit = '<p class="form-field-access">';
	                $access_bit .= elgg_view('input/access', array('internalname' => 'flexprofile_access['.$internalname.']','value'=>$access_id));
	                $access_bit .= '</p>';
            	} else {
	                $access_bit = '';
            	}
                $tab_data[$tab] .= $item->html.$access_bit;
            }
        }
    }
    $extra = '';
    foreach ($form_tabs['extra'] as $item) {
    	$extra .= $item->html;
    }
    return array('main' => $tab_data, 'extra'=>$extra);
}

function form_get_profile_data_from_form_post() {
    $form_id = get_input('form_id',0);
    $flexprofile_data = array();
    
    $data = array();
    $images = array();
    $maps = form_get_maps($form_id);
    // does not handle image uploads or required data right now, but should
    // best to use the function in the form plugin instead? Not sure ...
    if ($maps) {
        foreach($maps as $map) {
            $field = get_entity($map->field_id);
            $value = get_input('form_data_'.$field->internal_name,'');
            $flexprofile_data[$field->internal_name] = $value;
			if ($field->field_type == 'tags'){
            	// KJ - I reverse the array to fix an annoying Elgg tag order bug
            	// I will remove this workaround when the bug is fixed
				$flexprofile_data[$field->internal_name] = array_reverse(string_to_tag_array($flexprofile_data[$field->internal_name]));
            } else if ($field->field_type == 'image_upload') {
                // special handling for images
                $images[] = $field->internal_name;
            }
        }
    }
    
    $profile = get_entity($form_id)->profile;
    
    if ($profile == 1) {
    	$flexprofile_access = get_input('flexprofile_access','');    	
    }
                
    foreach($flexprofile_data as $name => $value) {
    	if (!in_array($name,$images)) {
	        $data[$name] = new StdClass();
	        $data[$name]->value = $value;
	        if ($profile == 1) {
	        	$data[$name]->access_id  = $flexprofile_access[$name];
	        } else {
	        	$data[$name]->access_id = ACCESS_PUBLIC;
	        }
    	}
    }
    
    // not sure if this should go here
	foreach($images as $image) {
		$formfieldname = 'form_data_'.$image;
		// don't do anything if this field is blank
		if (isset($_FILES[$formfieldname]['name']) && trim($_FILES[$formfieldname]['name'])) {
			// should probably delete the old image data somehow, if it exists
			$data[$image] = new StdClass();
			if ($profile == 1) {
	        	$data[$image]->access_id  = $flexprofile_access[$image];
	        } else {
	        	$data[$image]->access_id = ACCESS_PUBLIC;
	        }
			$data[$image]->value = form_handle_file_upload($formfieldname,$flexprofile_access[$image]);
		}
	}
    return $data;   
}

function form_set_data($entity,$data) {
    global $CONFIG;
    
    $entity_guid = $entity->getGUID();
    
    foreach($data as $name => $item) {
         // look for magic names first

    	elgg_delete_metadata($entity_guid, $name);
    	$value = $item->value;
    	if (is_array($value)) {
    		// currently tags and checkbox groups are the only field types returning multiple values
			$i = 0;
			foreach($value as $interval) {
				$i++;
				if ($i == 1) { $multiple = false; } else { $multiple = true; }
				create_metadata($entity_guid, $name, $interval, 'text', $entity_guid, $item->access_id, $multiple);
			}
		} else {
    		create_metadata($entity_guid, $name, $value, '', $entity_guid, $item->access_id);
		}
    }
}

function form_get_profile_config($category,$type='group') {
	if ($category) {
	    $profile_config = elgg_get_entities_from_metadata('category',$category,'object','form:profile_config');
	    if ($profile_config) {
	        return $profile_config[0];
	    } else {
	        $profile_config = new ElggObject();
	        $profile_config->subtype = 'form:profile_config';
	        $profile_config->owner_guid = 0;
	        $profile_config->access_id = ACCESS_PUBLIC;
	        $profile_config->category = $category;
	        if ($profile_config->save()) {
	        	return $profile_config;
	        }
	    }
	}
    return null;
}

?>
