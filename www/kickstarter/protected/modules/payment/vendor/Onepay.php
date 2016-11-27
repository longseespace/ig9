<?php

class Onepay {

  private $secureSecret;
  private $virtualPaymentClientURL;
  private $isValidSecureHash;
  private $isEmptySecureSecret;

  public function buildUrl($parameters) {
    $vpcURL = $this->virtualPaymentClientURL."?";
    $md5HashData = "";
    ksort ($parameters);
    $appendAmp = 0;

    foreach($parameters as $key => $value) {
      // create the md5 input and URL leaving out any fields that have no value
      if (strlen($value) > 0) {
        // this ensures the first paramter of the URL is preceded by the '?' char
        if ($appendAmp == 0) {
          $vpcURL .= urlencode($key) . '=' . urlencode($value);
          $appendAmp = 1;
        } else {
          $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
        }
        //$md5HashData .= $value; sử dụng cả tên và giá trị tham số để mã hóa
        if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
          $md5HashData .= $key . "=" . $value . "&";
        }
      }
    }

    //xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
    $md5HashData = rtrim($md5HashData, "&");
    // Create the secure hash and append it to the Virtual Payment Client Data if
    // the merchant secret has been provided.
    if (strlen($this->secureSecret) > 0) {
      //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
      // Thay hàm mã hóa dữ liệu
      $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$this->secureSecret)));
    }

    return $vpcURL;
  }

  public function setSecureSecret($secureSecret) {
    $this->secureSecret = $secureSecret;
  }

  public function setVirtualPaymentUrl($url) {
    $this->virtualPaymentClientURL = $url;
  }

  public function checkSum($parameters) {
    $vpc_Txn_Secure_Hash = $parameters["vpc_SecureHash"];
    $vpc_MerchTxnRef = $parameters["vpc_MerchTxnRef"];
    $vpc_AcqResponseCode = $parameters["vpc_AcqResponseCode"];
    unset($parameters["vpc_SecureHash"]);

    if (strlen($this->secureSecret) > 0 && $parameters["vpc_TxnResponseCode"] != "99" && $parameters["vpc_TxnResponseCode"] != "7") {
      ksort($parameters);
      $md5HashData = "";
      // sort all the incoming vpc response fields and leave out any with no value
      foreach ($parameters as $key => $value) {
        if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
          $md5HashData .= $key . "=" . $value . "&";
        }
      }

      $md5HashData = rtrim($md5HashData, "&");

      if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $this->secureSecret)))) {
        return true;
      } else {
        return false;
      }
    } else {
      return true;
    }
  }

}
?>