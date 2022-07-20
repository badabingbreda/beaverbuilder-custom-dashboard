<?php 

// If this file is called directly, abort.
if ( ! defined('WPINC') ) {
	die;
}


class BBCustomDashboard {

	// slug for the bb template to look for, change if already taken by another post/page or cpt
	protected static $dashboard_slug = 'dashboard';
	
	public function __construct() {
		
		// remove dashboard metaboxes by running late 999
		add_action( 'wp_dashboard_setup', __CLASS__ .  '::remove_dashboard_meta' , 999 );
		
		// enqueue layout styles and scripts in admin
		add_action( 'admin_enqueue_scripts', 'FLBuilder::register_layout_styles_scripts' );
		add_action( 'admin_enqueue_scripts', 'FLBuilder::enqueue_all_layouts_styles_scripts' );
		
		// enqueue custom styles and scripts in admin
		add_action( 'admin_enqueue_scripts', __CLASS__ .  '::enqueue_styles_scripts'  );
		
		// display layout
		add_action( 'admin_footer', __CLASS__ . '::display_dashboard_layout' );

	}
	
	/**
	 * remove_dashboard_meta
	 *
	 * @return void
	 */
	public static function remove_dashboard_meta() {
		
		global $wpdb;
		// test if our slug exists, otherwise return early
		$post_if = $wpdb->get_var("SELECT count(post_title) FROM $wpdb->posts WHERE post_name like '" . self::$dashboard_slug . "'");
		
		if ( !$post_if) return;

		global $wp_meta_boxes;

		// reset the wp_meta_boxes array to just our bb-dashboard
		$wp_meta_boxes = array( 
			'bb-dashboard' => array(
				'advanced' => array(),
				'side' => array(),
				'normal' => array(),
			) 
		);
	}
		
	/**
	 * enqueue_styles_scripts
	 *
	 * @return void
	 */
	public static function enqueue_styles_scripts() {
		wp_register_style( 'bbcd-styles', BBCUSTOMDASHBOARD_URL . 'assets/css/bbcd-admin.css', array() , BBCUSTOMDASHBOARD_VERSION, 'all' );
		wp_register_script( 'bbcd-js',  BBCUSTOMDASHBOARD_URL . 'assets/js/bbcd-admin.js', array(), BBCUSTOMDASHBOARD_VERSION );
		
		wp_enqueue_style( 'bbcd-styles' );
		wp_enqueue_script( 'bbcd-js' );
	}
		
	/**
	 * display_dashboard_layout
	 *
	 * @return void
	 */
	public static function display_dashboard_layout() {

		// show when visiting backend dashboard only
		if ( get_current_screen()->base !== 'dashboard' ) {
			return;
		}

		$layout = 	'<div id="bbcd-layout" class="welcome-panel" style="display: none;">';
		$layout .= 		'<div class="welcome-panel-content">';
		$layout .= 			\do_shortcode( '[fl_builder_insert_layout slug="' . self::$dashboard_slug . '" type="fl-builder-template"]' );
		$layout .= 		'</div>';
		$layout .= 	'</div>';

		echo $layout;
	}
}