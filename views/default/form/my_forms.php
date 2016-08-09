<?php

	/**
	 * Elgg display search form
	 * 
	 * @package Form
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 * 
	 * @uses $vars['form_id'] Optionally, the form to add a search definition for
	 */

 // load form model
 require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/models/model.php");
 
$form = $vars['form'];
$form_view = $vars['form_view'];
$username = $vars['username'];
if ($username) {
	$user = get_user_by_username($username);
} else {
	$user = get_loggedin_user();
}

$form_id = $form->getGUID();

$offset = (int) get_input('offset',0);
$limit = 10;

$entities = array();

if ($form_view == 'recommendations') {
    // get all the form data with recommendations, sorted with the most recommended at the top
    // TODO: replace with more efficient SQL
    $all_entities = get_entities_from_annotations("object", "form_data", "form:recommendation", "", 0, 0, 5000);
    if ($all_entities) {
        $entity_list = array();
        foreach($all_entities as $entity) {
            if ($entity->form_id == $form_id) {
                $count = count_annotations($entity->getGUID(), "object", "form_data", "form:recommendation");
                $item = new StdClass();
                $item->entity = $entity;
                $item->count = $count;
                $entity_list[] = $item;
            }
        }
        
        $sorted = form_vsort($entity_list,'count',true);
        foreach($sorted as $item) {
            $entities[] = $item->entity;
        }
        $entities = array_slice($entities,$offset,$limit);
    }
} else {

    if ($form_view == 'mine') {
        $user_guid = $user->getGUID();
    } else if ($form_view == 'friends') {
        // handles up to 5000 friends
        $friends = $user->getFriends("", 5000);
        $user_guid = array();
        if ($friends) {
            foreach ($friends as $friend) {
                $user_guid[] = $friend->getGUID();
            }
        }
    } else if ($form_view == 'all') {
        $user_guid = 0;
    } 
    
    if (!is_array($user_guid) || count($user_guid) > 0) {
    
        $count = elgg_get_entities_from_metadata('form_id', $form_id, 'object', 'form_data', $user_guid, $limit, $offset, "", 0, true);
        $entities = elgg_get_entities_from_metadata('form_id', $form_id, 'object', 'form_data', $user_guid, $limit, $offset, "", 0, false);
    }
}

if ($entities) {
	echo '<div class="form_listing">';
    echo form_view_entity_list($entities, $form, $count, $offset, $limit, false, true);
    echo '</div>';
} else {
    echo elgg_echo('form:no_search_results');
}

?>