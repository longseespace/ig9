<?php
  class NganluongThecao {

    private $success = false;
    private $message = null;
    private $amount = 0;
    private $trace_output = null;
    private $trace_input = null;

    private $merchant_id = '27614';
    private $merchant_password = 'ig9rock!';
    private $merchant_account = 'info@ig9.vn';

    private $messages = array(
      '99' => 'Lỗi chưa  xác nhận',
      '01' => 'Lỗi trong hệ thống',
      '02' => 'Lỗi trong hệ thống',
      '03' => 'Lỗi trong hệ thống',
      '04' => 'Lỗi trong hệ thống',
      '05' => 'Lỗi trong hệ thống',
      '06' => 'Lỗi trong hệ thống',
      '07' => 'Thẻ đã sử dụng',
      '08' => 'Thẻ bị khoá',
      '09' => 'Lỗi hết hạn sử dụng',
      '10' => 'Thẻ chưa kích hoạt hoặc không tồn tại',
      '11' => 'Mã thẻ sai định dạng',
      '12' => 'Sai số serial của thẻ',
      '13' => 'Mã thẻ và số serial không khớp',
      '14' => 'Thẻ không tồn tại',
      '15' => 'Thẻ không sử dụng được',
      '16' => 'Số lần thử (nhập sai liên tiếp) của thẻ vượt quá giới hạn cho phép',
      '17' => 'Hệ thống Telco bị lỗi hoặc quá tải',
      '18' => 'Hệ thống Telco bị lỗi hoặc quá tải, thẻ có thể bị trừ, xin vui lòng liên hệ hỗ trợ',
      '19' => 'Kết nối bị lỗi',
      '20' => 'Lỗi trong hệ thống, thẻ có thể bị trừ, xin vui lòng liên hệ hỗ trợ'
    );

    public function charge($params) {
      $user = Yii::app()->user->model();
      $params = array(
        'func' => 'CardCharge',
        'version' => '2.0',
        'merchant_id' => $this->merchant_id,
        'merchant_account' => $this->merchant_account,
        'merchant_password' => MD5($this->merchant_id.'|'.$this->merchant_password),
        'pin_card' => $params['pin_card'],
        'card_serial' => $params['card_serial'],
        'type_card' => $params['type_card'],
        'ref_code' => time(),
        'client_fullname' => $user->username,
        'client_email' => $user->email,
        'client_mobile' => $user->profile->mobile
      );

      $this->trace_input = $params;

      $post_field = '';
      foreach ($params as $key => $value){
        if ($post_field != '') $post_field .= '&';
        $post_field .= $key."=".$value;
      }
      $api_url = "https://www.nganluong.vn/mobile_card.api.post.v2.php";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$api_url);
      curl_setopt($ch, CURLOPT_ENCODING , 'UTF-8');
      curl_setopt($ch, CURLOPT_VERBOSE, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
      $result = curl_exec($ch);
      $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $error = curl_error($ch);
      if ($result != '' && $status==200){
        $arr_result = explode("|",$result);
        if (count($arr_result) == 13) {
          $error_code = $arr_result[0];
          $merchant_id = $arr_result[1];
          $merchant_account = $arr_result[2];
          $pin_card = $arr_result[3];
          $card_serial = $arr_result[4];
          $type_card = $arr_result[5];
          $ref_code = $arr_result[6];
          $client_fullname = $arr_result[7];
          $client_email = $arr_result[8];
          $client_mobile = $arr_result[9];
          $card_amount = $arr_result[10];
          $transaction_amount = $arr_result[11];
          $transaction_id = $arr_result[12];
          $this->trace_output = compact('error_code', 'merchant_id', 'merchant_account', 'pin_card', 'card_serial', 'type_card', 'ref_code', 'client_fullname', 'client_email', 'client_mobile', 'card_amount', 'transaction_amount', 'transaction_id');

          if ($error_code == '00'){
            $this->message = ___('Success');
            $this->amount = $card_amount;
            $this->success = true;
          } else {
            $this->message = $this->messages[$error_code];
          }
        } else {
          $this->trace_output = $array_result;
          $this->message = ___('Error on processing');
        }
      } else {
        $this->message = ___('Webservice error');
      }
    }

    public function getMessage() {
      return $this->message;
    }

    public function getTraceOutput() {
      return $this->trace_output;
    }

    public function getTraceInput() {
      return $this->trace_input;
    }

    public function getAmount() {
      return $this->amount;
    }

    public function isSuccess() {
      return $this->success;
    }
  }
?>