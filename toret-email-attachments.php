<?php
/**
 * @package   Toret Email Attachments
 * @author    Vladislav Musílek
 * @license   GPL-2.0+
 * @link      http://toret.cz
 * @copyright 2016 Toret.cz
 *
 * Plugin Name:       Toret Email Attachments
 * Plugin URI:        
 * Description:       Umožňuje přidat emailu o zpracovávané objednávce dvě přílohy a ke každému produktu v objednávce po jedné příloze.
 * Version:           1.1.0
 * Author:            Vladislav Musílek
 * Author URI:        toret.cz
 * Text Domain:       toret-email-attachments
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'TORETEADIR', plugin_dir_path( __FILE__ ) );
define( 'TORETEAURL', plugin_dir_url( __FILE__ ) );
define( 'TORETEA', 'toret-email-attachments');

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-toret-ea.php' );

register_activation_hook(   __FILE__, array( 'Toret_EA', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Toret_EA', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Toret_EA', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-toret-ea-admin.php' );
	add_action( 'plugins_loaded', array( 'Toret_EA_Admin', 'get_instance' ) );

}
