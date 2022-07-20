<?php
/**
 * Plugin Name: Beaver Builder Custom Dashboard
 * Plugin URI: http://www.bluedogdigitalmarketing.com
 * Description: Customize the WordPress Dashboard using a Beaver Builder Template
 * Version: 0.6.0
 * Author: Blue Dog Digital
 * Author URI: http://www.bluedogdigitalmarketing.com
 * License: GPL2
 * Text Domain: bbcd
 */
 
// If this file is called directly, abort.
if ( ! defined('WPINC') ) {
	die;
}

define( 'BBCUSTOMDASHBOARD_VERSION', '0.6.0' );
define( 'BBCUSTOMDASHBOARD_DIR', plugin_dir_path( __FILE__ ) );
define( 'BBCUSTOMDASHBOARD_FILE', __FILE__ );
define( 'BBCUSTOMDASHBOARD_URL', plugins_url( '/', __FILE__ ) );


require('classes/class-bb-custom-dashboard.php');

new BBCustomDashboard();