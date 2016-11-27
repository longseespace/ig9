<?php

class PaymentModule extends CWebModule
{
  /**
   * @var array
   * @desc gateways config
   */
  public $gateways;

  public $successUrl = "/pledge/success";
  public $errorUrl = "/pledge/error";
  public $backUrl;

}
