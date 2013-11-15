<?php

/*
Plugin Name: Multisite Event Sharing
Plugin Author: Patrick Johanneson
Author URI: http://patrickjohanneson.com/
Plugin URI: http://patj.ca/wp/plugins/ms-events
Description: Provides enhancements to Modern Tribe's "The Events Calendar" plugin for Multisite installations
Version: 0.1
License: GPL2
Requires: WordPress Multisite and The Events Calendar
*/

if( ! defined( 'ABSPATH' ) )
	die();

class MSE {

	var $prefix = 'mse-';
	
	function __construct() {
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		add_action( 'tribe_settings_do_tabs', array( $this, 'add_mse_settings_tab' ) );
		add_action( 'save_post', array( $this, 'promote_event' ) );
		
	}

	function activation() {
		if( ! is_multisite() ) {
			wp_die( "This plugin requires WordPress Multisite." );
		}

		if( ! class_exists( 'TribeEvents' ) ) {
			wp_die( "This plugin requires Modern Tribe's The Events Calendar plugin to be installed and activated." );
		}
	}

	// Well then.

	function add_mse_settings_tab() {

		$tab_id = 'mse';
		$tab_name = 'Multisite Events';
		$fields = array(

        $this->prefix . 'info-start' => array(
            'type' => 'html',
            'html' => '<div id="modern-tribe-info">'
        ),
        $this->prefix . 'info-box-title' => array(
            'type' => 'html',
            'html' => '<h2>' . __('Multisite Settings', 'ms-events') . '</h2>',
        ),
        $this->prefix . 'info-box-description' => array(
            'type' => 'html',
            'html' => '<p>' .  __('These settings control your Multisite experience.', 'ms-events' )  . '</p>',
        ),
			
        $this->prefix . 'info-end' => array(
            'type' => 'html',
            'html' => '</div>',
        ),

			$this->prefix . 'settings' => array(
				'id' => $this->prefix . 'settings',
				'label' => 'MS Events Settings',
				'type' => 'heading',
			),

			$this->prefix . 'hello' => array(
				'id' => $this->prefix . 'hello',
				'type' => 'text',
				'label' => 'Oh, hello there.',
				'validation_type' => 'html',
			),

			$this->prefix . 'text-box' => array(
				'id' => $this->prefix . 'text-box',
				'type' => 'text',
				'label' => 'Administrator email',
				'validation_type' => 'html',
				'default' => 'webmaster@example.com',
			),

			$this->prefix . 'admin-users' => array(
				'id' => $this->prefix. 'admin-users',
				'type' => 'dropdown',
				'options' =>  $this->_get_admin_users(),
				'validation_type' => 'options',
			),

		);

		$mse_tab = array(
			'fields' => $fields,
		);
		new TribeSettingsTab( 'mse', __( 'Multisite', 'multi-site-events' ), $mse_tab );

		// Properly:
		//  new TribeSettingsTab( 'display', __('Display', 'tribe-events-calendar'), $displayTab );
		
	}

	function _get_admin_users() {

		$args = array(
			'blog_id' =>get_current_blog_id(),
			'fields' => array( 'ID', 'display_name' ),
		);
		$users = get_users( $args );

		if( ! empty( $users ) ) {
			$tmp = array();
			foreach( $users as $u ) {
				$tmp[$u->ID] = $u->display_name;
			}
			$users = $tmp;
		} else { 
			$users = array( 0 => 'No admin users found.' );
		}
		return $users;
	}

	function _dump( $x ) {
		echo( "<pre>" );
		if( is_object( $x ) || is_array( $x ) ) {
			print_r( $x );
		} else {
			echo( $x );
		}
	}


	/*
	 * Event Promotion
	 */
	
	/**
	 * Hooked to save_post -- adds promoted event to root site list
	 * @param int $post_id The post's ID
	 * @since 0.1
	 */
	function promote_event( $post_id ) {
		if( ! tribe_is_event() ) {
			return;
		}
		wp_die( $this->prefix );
		
		
	}
	
	
	/*
	 * Promoted Event Collection
	 */
	
	/*
	 * Event Demotion
	 */
	
	/*
	 * TODO
	 *  - successfully promoted event status match to source event
	 *    (except publish if a) approval required & b) approval not granted)
	 *    probably use post_status_transition (?) hook
	 *  
	 */
}

new MSE();
