<?php
/*
	Plugin Name: Wp Shippo API
	Plugin URI: https://github.com/mmdmahbub/Wp-Shippo-API/
	Author: Mahbub Ansary
	Description: This plguin will allow to show rates based on address and size using shippo API
	Version: 1.0
	License: GPLv2 or later.
	Text Domain: Shippo API
	
*/
defined( 'ABSPATH' ) || exit;

require_once( plugin_dir_path( __FILE__ ) .'vendor/autoload.php');



function wp_shipping_api_getRates(){
	
Shippo::setApiKey('shippo_test_4948547a011b7b7b7a20b8b9528eeecd16b83bbe');

$from_city 	  	= $_POST['from_city'];
$from_state   	= $_POST['from_state'];
$from_zip 	  	= $_POST['from_zip'];
$from_country 	= $_POST['from_country'];

$to_city 	    = $_POST['to_city'];
$to_state 	    = $_POST['to_state'];
$to_zip 		= $_POST['to_zip'];
$to_country 	= $_POST['to_country'];


$length 		= $_POST['length'];
$width 			= $_POST['width'];
$height 		= $_POST['height'];
$distance_unit  = $_POST['distance_unit'];
$weight 		= $_POST['weight'];
$mass_unit		= $_POST['mass_unit'];





$from_address = array(
    'city' => $from_city,
    'state' => $from_state,
    'zip' => $from_zip,
    'country' => $from_country ,
);


$to_address = array(
    'city' => $to_city,
    'state' => $to_state,
    'zip' => $to_zip,
    'country' => $to_country,
);

$parcel = array(
    'length'=> $length,
    'width'=> $width,
    'height'=> $height,
    'distance_unit'=> 'in',
    'weight'=> $weight,
    'mass_unit'=> 'lb',
);


$shipment = Shippo_Shipment::create(
array(
    'address_from'=> $from_address,
    'address_to'=> $to_address,
    'parcels'=> array($parcel),
    'async'=> false,
));

// Rates are stored in the `rates` array inside the shipment object
$rates = $shipment['rates'];

// You can now show those rates to the user in your UI.
// Most likely you want to show some of the following fields:
//  - provider (carrier name)
//  - servicelevel_name
//  - amount (price of label - you could add e.g. a 10% markup here)
//  - days (transit time)
// Don't forget to store the `object_id` of each Rate so that you can use it for the label purchase later.
// The details on all of the fields in the returned object are here: https://goshippo.com/docs/reference#rates
echo "Available rates:" . "\n";
foreach ($rates as $rate) {
	echo "<pre>";
    echo "--> " . $rate['provider'] . " - " . $rate['servicelevel']['name'] . "\n";
    echo "  --> " . "Amount: "             . $rate['amount'] . "\n";
    echo "  --> " . "Days to delivery: "   . $rate['days'] . "\n";
	echo "</pre>";
}
echo "\n";


}

//create form shortcode
function wp_shipping_api_form ( $attr ){
	$form = '
		<div class="wp_shipping_form_wrapper">
			<form action="" method="post" id="wp_shipping_form">
				<div class="shipping_from">
					<h4> Shipping From Address </h4>
					<label>country</label>
					<select type="text" placeholder="" name="from_country" id="country">
						<option>Select Country</option>
					</select>
					<label>city</label>
					<input type="text" placeholder="" name="from_city" id="city">
					<label>state</label>
					<input type="text" placeholder="" name="from_state" id="state">
					<label>zip</label>
					<input type="text" placeholder="" name="from_zip" id="zip">
					
					
				</div>
				<div class="shipping_to">
				<h4> Shipping To Address </h4>
					<label>city</label>
					<input type="text" placeholder="" name="to_city" id="city">
					<label>state</label>
					<input type="text" placeholder="" name="to_state" id="state">
					<label>zip</label>
					<input type="text" placeholder="" name="to_zip" id="zip">
					<label>country</label>
					<label></label>
					<select type="text" placeholder="" name="to_country" id="to_country">
						<option>Select Country</option>
					</select>
				</div>
				<h4> Parcel details </h4>
				<input type="text" placeholder="" name="length" id="length">
				<input type="text" placeholder="" name="width" id="width">
				<input type="text" placeholder="" name="height" id="height">
				<input type="text" placeholder="" name="weight" id="weight">
				<input type="hidden" name="action" value="wp_shipping_form_action">
				<input type="submit" value="Check Rates">
			</form>
		</div>
		
	';
   
    return $form;
}



add_shortcode('wp_shipping_api_form', 'wp_shipping_api_form');