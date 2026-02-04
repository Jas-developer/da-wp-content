<?php
/**
 * Plugin Name: Custom Post Types (MU)
 * Description: Registers custom post types via mu-plugins.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


add_action('init','register_cpt');

function register_cpt(){

   //FOR JOB OPPORTUNITIES   
   register_post_type('job-opportunities', array(
    'labels' => array(
        'name' => 'Job Opportunities',
        'singular_name' => 'Job Opportunity',
        'add_new' => 'Add Job',
        'edit_item' => 'Edit JOB',
        'add_new_item' => 'Add New Job',
        'view_item' => 'View Job',
        'menu_name' => 'Job Opportunity',
        ),
    'public' => true,
    'supports' => ['title']
   ));



    // FOR TRANSPARENCY SEALS
    $labels = array(
        'name'               => 'Transparency Seals',
        'singular_name'      => 'Transparency Seal',
        'add_new'            => 'Add Transparency Seal',
        'add_new_item'       => 'Add New Transparency Seal',
        'edit_item'          => 'Edit Edit Transparency Seal',
        'new_item'           => 'New Transparency Seal',
        'view_item'          => 'View Transparency Seal',
        'menu_name'          => 'Transparency Seal',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 'title' ),
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'transparency' ),
        'show_in_rest'       => true, // IMPORTANT for Gutenberg & Elementor
    );

    register_post_type( 'transparency', $args );


}
