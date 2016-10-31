<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Messengerbot for WooCommerce
 * Plugin URI:        http://www.derweili.de
 * Description:       Stay in contact with you customers via Facebook Messenger. Send them notifications when the order status changes.
 * Version:           1.0
 * Author:            derweili
 * Author URI:        http://www.derweili.de/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /mbot-for-woocommerce/languages/
 * GitHub Plugin URI: https://github.com/derweili/fb-messenger-bot-for-woocommerce
 *
 */
if (!defined('ABSPATH'))
{
   exit();
}


//Include PHP Classes for API Call and Structured Messages




function derweili_mob_woocommerce_startswith($haystack, $needle){ 
    return strpos($haystack, $needle) === 0;
}


/**
* Plugin Class
*/
class DERWEILI_WOOCOMMERCE_FBBOT
{
	
	public function __construct()
	{
		$this->load_vendors();
		$this->define_credentials();


		if ( $this->credentials_not_empty() ) {
			$this->load_dependencies();
		}

		add_action( 'admin_init', array( &$this, 'load_admin_dependencies' ) );

	}

	// include php messenger sdk
	private function load_vendors() {

		include('vendor/fb-messenger-php/FbBotApp.php');
		include('vendor/fb-messenger-php/Messages/Message.php');
		include('vendor/fb-messenger-php/Messages/MessageButton.php');
		include('vendor/fb-messenger-php/Messages/StructuredMessage.php');
		include('vendor/fb-messenger-php/Messages/MessageElement.php');
		include('vendor/fb-messenger-php/Messages/MessageReceiptElement.php');
		include('vendor/fb-messenger-php/Messages/Address.php');
		include('vendor/fb-messenger-php/Messages/Summary.php');
		include('vendor/fb-messenger-php/Messages/Adjustment.php');

	}

	// Save credentials in php constants
	private function define_credentials() {
		
		//Define Messenger App Token
		define( "mbot_woocommerce_token", get_option( 'derweili_mbot_page_token' ) );

		//Define Messenger App Token
		define("mbot_woocommerce_verify_token", get_option( 'derweili_mbot_verify_token' ) );

		//Define Messenger App Token
		define("mbot_woocommerce_app_id", get_option( 'derweili_mbot_messenger_app_id' ) );

		//Define Messenger App Token
		define("mbot_woocommerce_page_id", get_option( 'derweili_mbot_page_id' ) );

	}

	// function to check if credentials are stored and available
	private function credentials_not_empty() {
		if ( !empty( mbot_woocommerce_token ) && !empty( mbot_woocommerce_verify_token ) && !empty( mbot_woocommerce_app_id ) && !empty( mbot_woocommerce_page_id ) ) return true;
	}


	// load other dependencies
	private function load_dependencies() {
		
		include('inc/WooOrderMessage.php');
		include('inc/woocommerce-thank-you.php');
		include('inc/filter-functions.php');

	}

	public function load_admin_dependencies() {

		include('inc/woocommerce-order-status-messages.php');
		include('inc/settingspage.php');


	}

	public function load_filter_functions() {

		include('inc/filter-functions.php');


	}

}

// Init App

new DERWEILI_WOOCOMMERCE_FBBOT;