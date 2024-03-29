![Image of Toktok](https://github.com/gacelabs/toktok-api/blob/main/TT_400x400.jpg)
# toktok-api
How to manage toktok deliveries thru Backend / end point calls

## Requirements 

* PHP 7.0 and up

## Installation 
with composer 
```cli
composer require gacelabs/toktok-api dev-main
```
[with zip](https://github.com/gacelabs/toktok-api/archive/refs/heads/main.zip) `https://github.com/gacelabs/toktok-api/archive/refs/heads/main.zip`

## Declarations
```php
define('TOKTOK_USER', '<YOUR PORTAL USERNAME>');
define('TOKTOK_PASSWORD', '<YOUR PORTAL PASSWORD>');
define('REFERRAL_CODE', '<YOUR TOKTOK REFERRAL CODE>');
```

## Usage
```php
include ('path/to/ToktokApi.php');
$api = new ToktokApi;
```
There are two types of end point list:
* portal 
* website

This is assigned in the `endpoint_list($type)` private method, where `$type` is (portal or website).

Found in [Line 184](https://github.com/gacelabs/toktok-api/blob/main/src/ToktokApi.php#L184)

## Example
To get toktok pricing and delivery directions, 
You can use this methos as your helper [toktok_price_directions_format.php](https://github.com/gacelabs/toktok-api/blob/main/helper/toktok_price_directions_format.php).

(Please see [$toktok_post](https://github.com/gacelabs/toktok-api/blob/main/helper/toktok_post_format.php) format).
```php
$pricing = price_and_directions($api, $toktok_post);

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
```php
$api->app_request('post_delivery', $toktok_post);
if ($api->success) {
  // get results here
  $data = $api->response;
} else {
  // throw $api->response error here
}
```
IF YOU LIKE MY WORK HERE? ANY AMOUNT OF DONATIONS WILL BE GLADLY APPRECIATED 🙌🙏🤝

[PAY PAL.ME](https://www.paypal.com/paypalme/datapushthru?country.x=PH&locale.x=en_US)

THANK YOU!

## Reporting Issues
Please [create an issue](https://github.com/gacelabs/toktok-api/issues) for any bugs, or submit merge requests. 

