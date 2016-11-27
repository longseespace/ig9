<?php

class Nganluong2 {

  private $secureSecret;
  private $virtualPaymentClientURL;
  private $isValidSecureHash;
  private $isEmptySecureSecret;

  public function buildUrl($parameters) {
    $arr_param = array(
      'merchant_site_code'=>  strval($parameters['merchant_site_code']),
      'return_url'    =>  strtolower(urlencode($parameters['return_url'])),
      'receiver'      =>  strval($parameters['receiver']),
      'transaction_info'  =>  strval($parameters['transaction_info']),
      'order_code'    =>  strval($parameters['order_code']),
      'price'       =>  strval($parameters['price'])
    );

    $arr_param['secure_code'] = md5(implode(' ', $arr_param) . ' ' . $this->secureSecret);

    $redirect_url = $this->virtualPaymentClientURL;
    if (strpos($redirect_url, '?') === false) {
      $redirect_url .= '?';
    } else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false) {
      $redirect_url .= '&';
    }

    $url = '';
    foreach ($arr_param as $key=>$value) {
      if ($url == '') {
        $url .= $key . '=' . $value;
      } else {
        $url .= '&' . $key . '=' . $value;
      }
    }

    return $redirect_url.$url;
  }

  public function setSecureSecret($secureSecret) {
    $this->secureSecret = $secureSecret;
  }

  public function setVirtualPaymentUrl($url) {
    $this->virtualPaymentClientURL = $url;
  }

  public function checkSum($parameters) {
    return true;
  }

}
?>