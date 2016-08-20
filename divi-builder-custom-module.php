<?php

/*
Plugin Name: Divi Builder Custom Module
Version: 0.0.1
Plugin URI: https://github.com/dszwed/divi-builder-custom-module
Description: Custom module for Divi Theme page builder
Author URI: http://wp360.pro/
Author: Dawid Szwed
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once('helpers.php');

function wp360_dbcm_init(){
    global $pagenow;
    
    $is_admin = is_admin();
    $action_hook = $is_admin ? 'wp_loaded' : 'wp';
    $required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' ); // list of admin pages where we need to load builder files
    $specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' );
    $is_edit_library_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
    $is_role_editor_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
    $is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import']; 
    $is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

    if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
        add_action($action_hook, 'wp360_dbcm_init_modules', 9789);
    }
}

add_action('init', 'wp360_dbcm_init');

function wp360_dbcm_init_modules(){
    if(class_exists("ET_Builder_Module")){
       include("recent-posts.php");
    }
}