<?php
/*
	Plugin Name: Elodin Balance Text
	Plugin URI: https://elod.in
    Description: Use the New York Times text-balancer library to balance text in WordPress. Just add the .bt class!
	Version: 0.1
    Author: Jon Schroeder
    Author URI: https://elod.in

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
*/


/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
    die( "Sorry, you are not allowed to access this page directly." );
}

// Define directories
define( 'ELODIN_BALANCE_TEXT_DIR', dirname( __FILE__ ) );
define( 'ELODIN_BALANCE_TEXT_URL', plugin_dir_url( __FILE__ ) );
define( 'ELODIN_BALANCE_TEXT_VERSION', '0.1' );

//* Define the default classes
define( 
    'ELODIN_BALANCE_TEXT_DEFAULTS', 
    array(
        '.bt', 
        '.balance-text', 
        'h1.has-text-align-center', 
        'h2.has-text-align-center',
        'p.has-text-align-center',
        '.has-text-align-center p'
    ),
);

//* Add scripts
add_action( 'wp_enqueue_scripts', 'elodin_balance_text_enqueue' );
function elodin_balance_text_enqueue() {
    
    wp_register_script( 'nyt-balance-text', ELODIN_BALANCE_TEXT_URL . 'vendor/text-balancer-nty/text-balancer.standalone.js', array(), ELODIN_BALANCE_TEXT_VERSION, true );
    // wp_register_script( 'nyt-balance-text', ELODIN_BALANCE_TEXT_URL . 'vendor/text-balancer-daniel-aleksanersen/text-balancer.js', array(), ELODIN_BALANCE_TEXT_VERSION, true );
    wp_register_script( 'nyt-balance-text-init', ELODIN_BALANCE_TEXT_URL . 'js/bt-init.js', array( 'nyt-balance-text' ), ELODIN_BALANCE_TEXT_VERSION, true );
    
    $classes = elodin_balance_text_get_final_classes();
    
    // bail if there aren't any classes to work with
    if ( !$classes )
        return;
        
    $classes = esc_html( implode( ', ', $classes ) );
        	    
    wp_localize_script( 
        'nyt-balance-text-init', 
        'elodinBalanceTextVars', 
        array(
            'classes' => $classes
        )
    );
    
    wp_enqueue_script( 'nyt-balance-text' );
    wp_enqueue_script( 'nyt-balance-text-init' );
    
}

//* Add base styles for these classes
add_action( 'wp_head', 'elodin_balance_text_base_styles' );
function elodin_balance_text_base_styles() {
    
    $classes = elodin_balance_text_get_final_classes();
    
    // bail if there aren't any classes to work with
    if ( !$classes )
        return;
        
    $classes = esc_html( implode( ', ', $classes ) );
    
    ?>
    <style>
        <?php echo $classes; ?> {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <?php
}

//* Left align on mobile
add_action( 'wp_head', 'elodin_balance_text_mobile_left' );
function elodin_balance_text_mobile_left() {
    
    $options = get_option( 'elodin_balance_text_page_options' );
    $disable_left_mobile = null;
    
    if ( isset( $options['disable_left_align_mobile'] ) )
        $disable_left_mobile = $options['disable_left_align_mobile'];
    
    // if the user says they don't want this then bail
    if ( $disable_left_mobile )
        return;
    
    $classes = elodin_balance_text_get_final_classes();
    
    // bail if there aren't any classes to work with
    if ( !$classes )
        return;
        
    $classes = esc_html( implode( ', ', $classes ) );
    
    ?>
    <style>
        @media( max-width: 600px ) {
            <?php echo $classes; ?> {
                text-align: left;
                margin-left: 0;
            }
        }
    </style>
    <?php
}

//* Add a metabox
require_once( 'lib/fields.php' );

function elodin_balance_text_get_final_classes() {

    $defaults = elodin_balance_text_get_defaults();
    $classes = elodin_balance_text_get_classes_option();
    
    $final_classes = array_merge( $classes, $defaults );
    $final_classes = array_unique( $final_classes );
        
    return $final_classes;
    
}

function elodin_balance_text_get_classes_option() {
    $options = get_option( 'elodin_balance_text_page_options' );
    
    if ( isset( $options['classes'] ) )
        $classes = $options['classes'];
    
    // set an empty array if there's nothing there
    if ( empty( $classes ) )
        $classes = [];
        
    return $classes;
}

function elodin_balance_text_get_defaults() {
    $options = get_option( 'elodin_balance_text_page_options' );
    $disable_defaults = null;
    
    if ( isset( $options['disable_left_align_mobile'] ) )
        $disable_defaults = esc_html( $options['disable_defaults'] );
        
    $defaults = [];
    
    // allow the defaults unless they're disabled by option
    if ( $disable_defaults !== 'on' )
        $defaults = ELODIN_BALANCE_TEXT_DEFAULTS;
                        
    return $defaults;
}