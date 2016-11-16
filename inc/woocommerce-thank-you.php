<?php
if (!defined('ABSPATH'))
{
   exit();
}


//
// hook into thank you page
//
function derweili_mbot_woocommerce_thank_you_message( $example, $order ) {

	//get messenger id from user
	$usermessengerid = get_user_meta( $order->get_user_id(), 'derweili_mbot_woocommerce_messenger_id', true );
	//if ( empty( $usermessengerid ) ) { // Display send to messenger button if no messenger id is stored

	    $send_to_messenger_button = '<div class="fb-send-to-messenger" 
	                  messenger_app_id="' . mbot_woocommerce_app_id . '" 
	                  page_id="' . mbot_woocommerce_page_id . '" 
	                  data-ref="derweiliSubscribeToOrder' . $order->id . '" 
	                  color="blue" 
	                  size="standard"></div>';
	    return '<div style="width: 100%; background-color:white; padding: 20px; margin-bottom:20px;"><h3>' . __( 'Get notified about Updates via Facebook Messenger', 'mbot-woocommerce' ) . '</h3>' . $send_to_messenger_button . '</div>' . $example;

	/*}else{

		//If user already has messenger id, send order notification to messenger
		$bot = new FbBotApp( mbot_woocommerce_token );
		$bot->send(new WooOrderMessage( $message['sender']['id'], $order ) );

	}*/
    
}
add_filter( 'woocommerce_thankyou_order_received_text', 'derweili_mbot_woocommerce_thank_you_message', 10, 2 );




// place messenger script into footer
add_action('wp_footer', 'derweili_mbot_woocommerce_thank_you_script', 10);

function derweili_mbot_woocommerce_thank_you_script(){ ?>
	<script>
	  /*window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '<?php echo mbot_woocommerce_app_id; ?>',
		      xfbml      : true,
		      version    : 'v2.6'
		    });
		  };*/

		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
	</script>
<?php
}