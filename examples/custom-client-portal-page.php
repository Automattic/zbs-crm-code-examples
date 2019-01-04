<?php
/*
Plugin Name: Zero BS CRM [Example Code]
Plugin URI: https://zerobscrm.com
Description: This code example adds a custom tab to the Zero BS CRM Client Portal
Version: 1.0
Author: <a href="https://zerobscrm.com">Zero BS CRM</a>
Text Domain: zerobscrm
*/

/* 
	Add your own endpoint (this is your page slug) 
	* Make sure you change this in both instances below: 'yourendpoint'
*/
add_filter('zbs_portal_endpoints', 'zeroBSCRM_clientPortal_yourEndpoint');
function zeroBSCRM_clientPortal_yourEndpoint($allowed_endpoints){
	$allowed_endpoints[] = 'yourendpoint';
	return $allowed_endpoints;
}
function zeroBSCRM_portal_your_endpoint() {
	add_rewrite_endpoint( 'yourendpoint', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'zeroBSCRM_portal_your_endpoint' );

/* 
	Here we add a menu item to the client portal tabbed menu
	* Make sure 'yourendpoint' matches the endpoint specified above, and don't forget to change your menu name!
	* The "fa-icon" string represents a font-awesome v4 icon: https://fontawesome.com/v4.7.0/icons/
*/
add_filter('zbs_portal_nav_menu_items', 'zeroBSCRM_clientPortal_yourendpointMenu');
function zeroBSCRM_clientPortal_yourendpointMenu($nav_items){
	$nav_items['yourendpoint'] = array('name' => 'Nav Menu Name', 'icon' => 'fa-icon', 'show' => 1);
	return $nav_items;
}

/* 
	Here's where we actually expose the content:
*/
add_action('zbs_portal_yourendpoint_endpoint', 'zeroBSCRM_clientPortal_yourendpoint');
function zeroBSCRM_clientPortal_yourendpoint(){
	do_action('zbs_pre_yourendpoint_content');
	if(!is_user_logged_in()){
		return zeroBS_get_template('login.php');
	}else{
		if (!zeroBSCRM_portalIsUserEnabled())
			return zeroBS_get_template('disabled.php');
		else
			return zeroBSCRM_clientPortalProCustomerYour_Content();
	}
	do_action('zbs_post_yourendpoint_content');
}

/* 
	This example loads a html file from the plugin directory (same as this file)
*/
function zeroBSCRM_clientPortalProCustomerYour_Content(){
	$template_file = plugin_dir_path(__FILE__) . "portal-page.php";
	include $template_file;
}


?>