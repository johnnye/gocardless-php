<?php

// Include library
include_once '../lib/GoCardless.php';

// Sandbox
GoCardless::$environment = 'sandbox';

// Config vars
$account_details = array(
  'app_id'        => null,
  'app_secret'    => null,
  'merchant_id'   => null,
  'access_token'  => null
);

// Initialize GoCardless
GoCardless::set_account_details($account_details);

// Use this line to fetch the body of the HTTP request
$webhook = file_get_contents('php://input');

// Or use this json blog for testing
//$webhook = '{
//    "payload": {
//        "resource_type": "bill",
//        "action": "paid",
//        "bills": [
//            {
//                "id": "AKJ398H8KA",
//                "status": "paid",
//                "source_type": "subscription",
//                "source_id": "KKJ398H8K8",
//                "paid_at": "2011-12-01T12:00:00Z",
//                "uri": "https://sandbox.gocardless.com/api/v1/bills/AKJ398H8KA"
//            },
//            {
//                "id": "AKJ398H8KB",
//                "status": "paid",
//                "source_type": "subscription",
//                "source_id": "8AKJ398H78",
//                "paid_at": "2011-12-09T12:00:00Z",
//                "uri": "https://sandbox.gocardless.com/api/v1/bills/AKJ398H8KB"
//            }
//        ],
//        "signature": "f6b9e6cd8eef30c444da48370e646839c9bb9e1cf10ea16164d5cf93a50231eb"
//    }
//}';

$webhook_array = json_decode($webhook, true);

if (GoCardless::validate_webhook($webhook['payload'])) {

  header('HTTP/1.1 200 OK');

  $log = fopen("webhooks.txt", "a");
  fwrite($log, print_r($webhook, TRUE)."\n\n");
  fclose($log);

}
