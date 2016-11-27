<?php
  return array(
    'import'=>array(
      'application.modules.payment.*',
      'application.modules.payment.models.*',
      'application.modules.payment.components.*',
      'application.modules.payment.vendor.*'
    ),
    'modules' => array(
      'payment' => array(
        'successUrl' => '/pledge/success',
        'errorUrl' => '/pledge/error',
        'backUrl' => '/pledge/paymentmethod',
        'gateways' => array(
          'onepay_noidia' => array(
            'params' => array(
              'vpc_Version' => '2',
              'vpc_Command' => 'pay',
              'vpc_AccessCode' => 'D67342C2',
              'vpc_Merchant' => 'ONEPAY',
              'vpc_Locale' => 'vn',
              'vpc_Currency' => 'VND',
              'vpc_ReturnURL' => 'http://'. $_SERVER['SERVER_NAME'] . '/payment/default/onepaynoidiacallback',
              'vpc_BackURL' => 'http://'. $_SERVER['SERVER_NAME'] . '/payment/default/onepaynoidiacallback',
            ),
            'secure_secret' => 'A3EFDFABA8653DF2342E8DAC29B51AF0',
            'virtual_payment_url' => 'http://mtf.onepay.vn/onecomm-pay/vpc.op'
          ),
          'onepay_quocte' => array(
            'params' => array(
              'AgainLink' => $_SERVER['SERVER_NAME'],
              'Title' => 'ig9.vn',
              'vpc_Version' => '2',
              'vpc_Command' => 'pay',
              'vpc_AccessCode' => '6BEB2546',
              'vpc_Merchant' => 'TESTONEPAY',
              'vpc_Locale' => 'vn',
              'vpc_ReturnURL' => 'http://'. $_SERVER['SERVER_NAME'] . '/payment/default/onepayquoctecallback',
            ),
            'secure_secret' => '6D0870CDE5F24F34F3915FB0045120DB',
            'virtual_payment_url' => 'http://mtf.onepay.vn/vpcpay/vpcpay.op'
          ),
          'nganluong' => array(
            'params' => array(
              'merchant_site_code'=> '27603',
              'return_url' => 'http://'. $_SERVER['SERVER_NAME'] . '/payment/default/nganluongcallback',
              'receiver' => 'support@6ix.vn',
              'transaction_info' =>  'NganLuong'
            ),
            'secure_secret' => 'abc123',
            'virtual_payment_url' => 'https://www.nganluong.vn/checkout.php'
          ),
          'credit' => array(
            'params' => array(
              'return_url' => 'http://'. $_SERVER['SERVER_NAME'] . '/payment/default/creditcallback'
            ),
            'secure_secret' => '123456',
            'virtual_payment_url' => 'http://'. $_SERVER['SERVER_NAME'] . '/payment/credit/use',
          )
        )
      )
    )
  );
?>