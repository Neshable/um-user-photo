<?php

/**
 * Plugin Name:       Ultimate Member - Add User Photo from Admin
 * Plugin URI:        none
 * Description:       Allow admin to change user photo from user edit page and choose from media library.
 * Version:           1.0.0
 * Author:            Nesho Sabakov
 * Author URI:        http://softsab.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );


/**
 * The core plugin class
 */


if ( ! class_exists( 'UM' ) ) {
	// UM is not active
	function utlimate_member_not_active() {
		echo '<div class="error"><p>' . sprintf( __( 'The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>', 'um-terms-conditions' ), um_terms_conditions_extension ) . '</p></div>';
	}

	add_action( 'admin_notices', 'utlimate_member_not_active' );

} else {
	require plugin_dir_path( __FILE__ ) . 'includes/class-um-user-photo.php';


	function run_um_user_photo() {
		$plugin = new UM_User_Photo();
	}

	run_um_user_photo();
}



