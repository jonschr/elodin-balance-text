<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'elodin_balance_text_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */


if ( file_exists( ELODIN_BALANCE_TEXT_DIR . '/vendor/cmb2/init.php' ) ) {
	require_once ELODIN_BALANCE_TEXT_DIR . '/vendor/cmb2/init.php';
} elseif ( file_exists( ELODIN_BALANCE_TEXT_DIR . '/vendor/CMB2/init.php' ) ) {
	require_once ELODIN_BALANCE_TEXT_DIR . '/vendor/CMB2/init.php';
}

/**
 * Hook in and register a submenu options page for the Page post-type menu.
 */
function elodin_balance_text_register_options_submenu_for_page_post_type() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb = new_cmb2_box( array(
		'id'           => 'elodin_balance_text_options_submenu_page',
		'title'        => esc_html__( 'Balance Text', 'cmb2' ),
		'object_types' => array( 'options-page' ),
		'option_key'      => 'elodin_balance_text_page_options', // The option key and admin menu page slug.
		'parent_slug'     => 'options-general.php', // Make options page a submenu item of the themes menu.
	) );
    
    //* Repeater
    $repeater_group_id = $cmb->add_field( array(
		'id'          => 'classes',
		'type'        => 'text',
        'desc'    => 'Add additional css selectors for the text you\'d like to automatically balance. Please note that you must target the element itself and not a wrapper element, e.g. always target the paragraph or heading instead of the div that wraps it. That wrapper div must set the max-width of the inner element, as we can\'t touch the width of the element itself.',
		'repeatable'  => true,
	) );
    
    //* Checkbox
    // get the defaults for later use
    $defaults = implode( ', ', ELODIN_BALANCE_TEXT_DEFAULTS );
    $desc = sprintf( 'Disable the following defaults (you can still add some of them above):  <strong>%s</strong>', $defaults );
    
    $cmb->add_field( array(
        'id'   => 'disable_left_align_mobile',
        'type' => 'checkbox',
        'name' => 'Disable left alignment on mobile',
        'desc' => 'Some people, like this humble plugin author, prefer to default to left alignment on mobile for virtually all text. So that\'s the default. Allow center alignment on mobile instead (you can also override this in css).',
    ) );
        
    // add a checkbox
    $cmb->add_field( array(
        'id'      => 'disable_defaults',
        'type' => 'checkbox',
        'name' => 'Disable default classes',
        'desc' => $desc,
    ) );
    
    
}

add_action( 'cmb2_admin_init', 'elodin_balance_text_register_options_submenu_for_page_post_type' );
