<?php
  require_once('configstr.php');

  $token  = $_POST['stripeToken'];

  $customer = Stripe_Customer::create(array(
      'email' => 'customer@example.com',
      'card'  => $token
  ));

  $charge = Stripe_Charge::create(array(
      'customer' => $customer->id,
      'amount'   => 5000,
      'currency' => 'usd'
  ));

  echo '<h1>Successfully charged $50.00!</h1>';
?>