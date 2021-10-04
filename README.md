# toktok-api
How to manage toktok deliveries thru Backend / end point calls

## Requirements 

* PHP 7.0 and up

## Installation 
Install with composer 
```
composer require gacelabs/toktok-api 1.0.0
```

## Declarations
```
define('TOKTOK_USER', '<YOUR PORTAL USERNAME>');
define('TOKTOK_PASSWORD', '<YOUR PORTAL PASSWORD>');
define('REFERRAL_CODE', '<YOUR TOKTOK REFERRAL CODE>');
```

## Usage
```
$api = new ToktokApi;
```
There are two types of end point list:
* portal 
* website
This is assigned in the `endpoint_list($type)` private method, where `$type` is (protal or website).

Found in [Line 185](https://github.com/gacelabs/toktok-api/blob/main/ToktokApi.php)

## Example
To get toktok pricing and delivery directions, 
You can use this methos as your helper [toktok_price_directions_format.php](https://github.com/gacelabs/toktok-api/blob/main/toktok_price_directions_format.php).

(Please see [$toktok_post](https://github.com/gacelabs/toktok-api/blob/main/toktok_post_format.php) format).
```
$pricing = price_and_directions($api, $toktok_post)

$api->app_request('price_and_directions', $pricing);
if ($api->success) {
  $toktok_dpd = $api->response['result']['data']['getDeliveryPriceAndDirections'];
  $toktok_post['f_post'] = json_encode(['hash'=>$toktok_dpd['hash']], JSON_NUMERIC_CHECK);
  $toktok_post['f_distance'] = $toktok_dpd['pricing']['distance'] . ' km';
  $toktok_post['f_duration'] = format_duration($toktok_dpd['pricing']['duration']);
  $toktok_post['f_price'] = $toktok_dpd['pricing']['price'];
  $toktok_post['f_sender_mobile'] = preg_replace('/-/', '', $toktok_post['f_sender_mobile']);
  $toktok_post['f_recepient_mobile'] = preg_replace('/-/', '', $toktok_post['f_recepient_mobile']);
  $toktok_post['referral_code'] = REFERRAL_CODE;
}
```
Posting your order via toktok api:
```
$api->app_request('post_delivery', $toktok_post);
if ($api->success) {
  // get results here
  $data = $api->response['result'];
} else {
  // throw $api->response error here
}
```
IF YOU LIKE MY WORK HERE? ANY AMOUNT OF DONATIONS WILL BE GLADLY APPRECIATED 🙌🙏🤝

[PAY PAL.ME](https://www.paypal.com/donate?hosted_button_id=HC7H6MBGR9SQW)

THANK YOU!

## Reporting Issues
Please [create an issue](https://github.com/gacelabs/toktok-api/issues) for any bugs, or submit merge requests. 

