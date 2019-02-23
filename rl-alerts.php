<?php
/*
Plugin Name: RL Alerts
Version:     1.0.0
Plugin URI:  https://rosieleung.com/
Description: Adds a WYSIWYG field for site-wide alerts that can be minimized and maximized
Author:      Rosie Leung
Author URI:  mailto:rosie@rosieleung.com
License:     GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RL_ALERTS_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'RL_ALERTS_PATH', dirname( __FILE__ ) );
define( 'RL_ALERTS_VERSION', '1.0.0' );

add_action( 'plugins_loaded', 'rl_alerts_init_plugin' );

function rl_alerts_init_plugin() {
	
	if ( ! class_exists( 'acf' ) ) {
		add_action( 'admin_notices', 'rl_alerts_warn_no_acf' );
		
		return;
	}
	
	include_once( RL_ALERTS_PATH . '/includes/enqueue.php' );
	include_once( RL_ALERTS_PATH . '/includes/rl-alerts.php' );
}

// Display ACF required warning on admin if ACF is not activated
function rl_alerts_warn_no_acf() {
	?>
	<div class="error">
		<p><strong>RL Alerts Plugin:</strong> This plugin requires Advanced Custom Fields PRO in order to operate. Please install and activate ACF Pro, or disable this plugin.</p>
	</div>
	<?php
}