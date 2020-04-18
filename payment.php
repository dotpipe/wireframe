<?php

  namespace adoms\oauth2;

  $db = new $db();
  $res = $db->read(array("users" => ['site_id', 'grad_fee', 'month', 'day', 'fee', 'views_month', 'views_total' ]), "`site_id` = '" . $_COOKIE['PHPSESSID'] . "'");

  if ($res[0]['month'] < date("m",time()) && $res[0]['day'] <= date("d",time()) && ($res[0]['fee'] + round($res[0]['views_month'] * $res[0]['grad_fee'],2)) < 1) {
    echo 'There is no payment due. You did not receive enough hits last month (min. $1). Your hits do not roll over.';
    $db->update("users",['views_total' => ($res[0]['views_month'] + $res[0]['views_total']), 'fee' => 0, 'views_month' => 0], "`site_id` = '" . $res[0]['site_id'] . "'");
  }
  else if ($res[0]['month'] < date("m",time()) && $res[0]['day'] <= date("d",time())) {
    echo "You owe, " . $res[0]['views_month'] * $res[0]['grad_fee'] . ".<br>";
    echo "You had " . $res[0]['views_month'] . " hits since " . $res[0]['month'] . " Congratulations!<br>"; 
    echo "Your pay schemes: <br>";
    echo "<ul>150,000 - 10,000,000 = $0.0018/hit</ul>";
    echo "<ul>50,001 - 150,000 = $0.0006/hit</ul>";
    echo "<ul>0 - 50,000 = $0.0002/hit</ul>";
    $db->update("users",['fee' => ($res[0]['fee'] + round($res[0]['views_month'] * $res[0]['grad_fee'],2))],"`site_id` = '" . $res[0]['site_id'] . "'");
    echo "<img id='paypal-button' src='view/pictures/paypal-sb-standard.png'/>";
  }
?>


//<!-- Load the required checkout.js script -->
<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>

//<!-- Load the required Braintree components. -->
<script src="https://js.braintreegateway.com/web/3.39.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.39.0/js/paypal-checkout.min.js"></script>

<script>
paypal.Button.render({
  braintree: braintree,
  client: {
    production: 'CLIENT_TOKEN_FROM_SERVER',
    sandbox: 'CLIENT_TOKEN_FROM_SERVER'
  },
  env: 'production', // Or 'sandbox'
  commit: true, // This will add the transaction amount to the PayPal button

  payment: function (data, actions) {
    return actions.braintree.create({
      flow: 'checkout', // Required
      amount: <?= round($res[0]['views_month'] * $res[0]['grad_fee'],2); ?>, // Required
      currency: 'USD', // Required
    });
  },

  onAuthorize: function (payload) {
    // Submit `payload.nonce` to your server.
  },
}, '#paypal-button');
</script>
