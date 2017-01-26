<?php

if (!defined('ABSPATH'))
{
   exit();
}


/**
* NOTE: Shipping Handler
*/
class Derweili_Order_Shipping_Handler
{

	private $order_id = null;
	private $tracking_plugin = null;

	// General Shipping Info
	private $tracking_code = null;
	private $tracking_provider_name = null;
	private $tracking_url = null;


	// Aftership details
	private $tracking_provider = null;
	
	function __construct( $order_id )
	{
		
		$this->order_id = $order_id;

		$this->get_shipping_type();

	}


	private function get_shipping_type() {

		if ( ! empty( get_post_meta( $this->order_id, '_aftership_tracking_provider', true ) ) ) {
			
			$this->tracking_plugin = "aftership";

		}

	}

	public function has_shipping() {
		if ( null != $this->tracking_plugin ) return true;
	}

	private function get_shipping_details() {

		switch ( $this->tracking_plugin ) {
			case 'aftership':
				
				$this->get_aftership_details();

				break;
			
			default:
				# code...
				break;
		}

	}

	private function get_aftership_details() {

		$this->tracking_code = get_post_meta( $this->order_id, '_aftership_tracking_number', true )
		$this->tracking_provider_name = get_post_meta( $this->order_id, '_aftership_tracking_provider_name', true )
		$this->tracking_provider = get_post_meta( $this->order_id, '_aftership_tracking_provider', true )
		
		$this->tracking_url = "https://track.aftership.com/" . $this->tracking_provider . "/" . $this->tracking_code;

	}

	private function get_tracking_url() {

		$this->get_shipping_details();

		return $this->tracking_url;

	}

}