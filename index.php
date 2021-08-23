<?php
/*
	Plugin Name: Wp Shippo API
	Plugin URI: https://akismet.com/
	Author: Mahbub Ansary
	Description: This plguin will allow to show rates based on address and size using shippo API
	Version: 1.0
	License: GPLv2 or later.
	Text Domain: Shippo API
	
*/


require_once( plugin_dir_path( __FILE__ ) .'vendor/autoload.php');


function getRates(){

Shippo::setApiKey('shippo_test_4948547a011b7b7b7a20b8b9528eeecd16b83bbe');

$from_address = array(
    'city' => 'San Francisco',
    'state' => 'CA',
    'zip' => '94117',
    'country' => 'US',
);

// Example to_address array
// The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
$to_address = array(
    'city' => 'San Diego',
    'state' => 'CA',
    'zip' => '92101',
    'country' => 'US',
);

// Parcel information array
// The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
$parcel = array(
    'length'=> '5',
    'width'=> '5',
    'height'=> '5',
    'distance_unit'=> 'in',
    'weight'=> '2',
    'mass_unit'=> 'lb',
);

// Example shipment object
// For complete reference to the shipment object: https://goshippo.com/docs/reference#shipments
// This object has async=false, indicating that the function will wait until all rates are generated before it returns.
// By default, Shippo handles responses asynchronously. However this will be depreciated soon. Learn more: https://goshippo.com/docs/async
$shipment = Shippo_Shipment::create(
array(
    'address_from'=> $from_address,
    'address_to'=> $to_address,
    'parcels'=> array($parcel),
    'async'=> false,
));

// Rates are stored in the `rates` array inside the shipment object
//$rates = $shipment['rates'];

// You can now show those rates to the user in your UI.
// Most likely you want to show some of the following fields:
//  - provider (carrier name)
//  - servicelevel_name
//  - amount (price of label - you could add e.g. a 10% markup here)
//  - days (transit time)
// Don't forget to store the `object_id` of each Rate so that you can use it for the label purchase later.
// The details on all of the fields in the returned object are here: https://goshippo.com/docs/reference#rates
//echo "Available rates:" . "\n";
//foreach ($rates as $rate) {
	//echo "<pre>";
   // echo "--> " . $rate['provider'] . " - " . $rate['servicelevel']['name'] . "\n";
    //echo "  --> " . "Amount: "             . $rate['amount'] . "\n";
    //echo "  --> " . "Days to delivery: "   . $rate['days'] . "\n";
	//echo "</pre>";
//}
//echo "\n";

}
?>



