<?php

/**
 * Manage group categories
 * 
 * @package Elgg
 * @subpackage Form
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 */
 
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Load form model
require_once(dirname(__FILE__)."/models/profile.php");
    
// Define context
set_context('form:admin');

admin_gatekeeper();

$group_profile_categories = form_get_group_profile_categories();

$title = elgg_echo('form:manage_group_profile_categories_title');
$body = elgg_view('form/forms/manage_group_profile_categories',array('group_profile_categories'=>$group_profile_categories));

page_draw($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body));

?>