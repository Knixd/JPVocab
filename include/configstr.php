<?php
	require('lib/Stripe.php');

	$stripe = array(
	  "secret_key"      => "sk_test_4SH6C0jWJvwIwzKUD9M0SPE6", //swap these with my live keys eventually
	  "publishable_key" => "pk_test_4SH6BeoMedNt9VXzOOiofBE8"
	);

	Stripe::setApiKey($stripe['secret_key']);
?>