<?php
namespace vendor\braintree\braintree_php\lib\Braintree;
use Adoms\oauth2;
require_once 'vendor/composer/autoload_classmap.php';
$gateway = new Braintree_Gateway([
  'environment' => 'sandbox',
  'merchantId' => 'n5bdvsd3ghwffd4k',
  'publicKey' => 'xmg2fvqdxsq3dw2n',
  'privateKey' => 'bc696d30a1bb129f53b1f4a7e306c4a7'
]);

$clientToken = $gateway->clientToken()->generate([
  "customerId" => $_COOKIE['PHPSESSID']
]);

echo($clientToken = $gateway->clientToken()->generate());

$db = new db();
$res = $db->read(array("users" => ['site_id', 'grad_fee', 'month', 'day', 'fee', 'views_month', 'views_total' ]), "`site_id` = '" . $_COOKIE['PHPSESSID'] . "'");
$result = [];
if ($res[0]['month'] < date("m",time()) && $res[0]['day'] <= date("d",time()) && ($res[0]['fee'] + round($res[0]['views_month'] * $res[0]['grad_fee'],2)) < 1) {
  echo 'There is no payment due. You did not receive enough hits last month (min. $1). Your hits do not roll over.';
  $db->update("users",['views_total' => ($res[0]['views_month'] + $res[0]['views_total']), 'fee' => 0, 'views_month' => 0], "`site_id` = '" . $res[0]['site_id'] . "'");
}
else if ($res[0]['month'] < date("m",time()) && $res[0]['day'] <= date("d",time())) {
  $db->update("users",['fee' => ($res[0]['fee'] + round($res[0]['views_month'] * $res[0]['grad_fee'],2))],"`site_id` = '" . $res[0]['site_id'] . "'");
  $result = $gateway->transaction()->sale([
    'amount' => ($res[0]['fee'] + round($res[0]['views_month'] * $res[0]['grad_fee'],2)),
    'paymentMethodNonce' => $_POST["payment_method_nonce"],
    //'deviceData' => $deviceDataFromTheClient,
    'options' => [
      'submitForSettlement' => True
    ]
  ]);
  echo "<img id='paypal-button' src='view/pictures/paypal-sb-standard.png'/>";
}

if ($result->success) {
  print_r("Success ID: " . $result->transaction->id);
} else {
  print_r("Error Message: " . $result->message);
}
?>
<style>
.button {
  cursor: pointer;
  font-weight: 500;
  left: 3px;
  line-height: inherit;
  position: relative;
  text-decoration: none;
  text-align: center;
  border-style: solid;
  border-width: 1px;
  border-radius: 3px;
  -webkit-appearance: none;
  -moz-appearance: none;
  display: inline-block;
}

.button--small {
  padding: 10px 20px;
  font-size: 0.875rem;
}

.button--green {
  outline: none;
  background-color: #64d18a;
  border-color: #64d18a;
  color: white;
  transition: all 200ms ease;
}

.button--green:hover {
  background-color: #8bdda8;
  color: white;
}
</style>
<script src="https://js.braintreegateway.com/web/dropin/1.22.1/js/dropin.js"></script>
<script>
var button = document.querySelector('#submit-button');

braintree.dropin.create({
  authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
  selector: '#dropin-container'
}, function (err, instance) {
  button.addEventListener('click', function () {
    instance.requestPaymentMethod(function (err, payload) {
      // Submit payload.nonce to your server
    });
  })
});
</script>
<!-- Load the required client component. -->
<script src="https://js.braintreegateway.com/web/3.60.0/js/client.min.js"></script>

<!-- Load additional components when required. -->

<!-- Use the components. We'll see usage instructions next. -->
<script>
braintree.client.create({
  authorization: 'CLIENT_AUTHORIZATION'
});
</script>
<div id="dropin-container"></div>
<button id="submit-button" class="button button--small button--green">Purchase</button>
<!-- You'll need a div that will become your PayPal button. -->
<div id="paypal-button"></div>

<!-- Be sure to include checkout.js on your page. -->
<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4 log-level="warn"></script>
