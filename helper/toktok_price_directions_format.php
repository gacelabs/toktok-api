<?php

  function find_value($value='', $data=[], $column='', $results=false)
  {
    $data = (array) $data;
    $key = array_search($value, array_column($data, $column));
    
    if (is_numeric($key)) {
      return $results ? $data[$key] : true;
    }
    return false;
  }

  function price_and_directions($api, $data=false, $vehicle='Motorcycle')
  {
    $api->app_request('vehicle_types');
    $vehicle_id = 'DEFAULT ID'; // sample only
    if ($api->success) {
      $vehicle = find_value($vehicle, $api->response['message'], 'type', true);
      $vehicle_id = $vehicle['id'];
    }
    $pricing = [
      'f_sender_lat' => $data ? $data['f_sender_address_lat'] : 0,
      'f_sender_lon' => $data ? $data['f_sender_address_lng'] : 0,
      'f_promo_code' => '',
      'destinations' => [
        [
          'recipient_lat' => $data ? $data['f_recepient_address_lat'] : 0,
          'recipient_lon' => $data ? $data['f_recepient_address_lng'] : 0,
        ]
      ],
      'isExpress' => 'false', // if f_express_fee is true set this to 'true'
      'isCashOnDelivery' => 'true', // if f_is_cod is off set this to 'false'
      'vehicleTypeId' => $vehicle_id,
    ];
    return $pricing;
  }

  function format_duration($duration=0)
  {
    if ($duration) {
      $duration = (float)$duration;
      if ($duration <= 60) {
        if ($duration == 60) {
          $duration = '1 hour';
        } else {
          $duration .= ' minutes';
        }
      } else {
        $hours = floor((float)($duration / 60));
        $minutes = ceil((float)($duration % 60));
        if ($hours == 1) {
          $duration = '1 hour ';
        } else {
          $duration .= $hours . ' hours ';
        }
        if ($minutes == 1) {
          $duration .= $minutes . ' minute';
        } elseif ($minutes > 1) {
          $duration .= $minutes . ' minutes';
        }
      }
    }
    return preg_replace('/\s+/', ' ', $duration);
  }
?>
