<?php

  class AppHelper extends CComponent {

    public static function trim($content, $length=60) {
      $c = strip_tags($content);
      return strlen($c) > $length ? substr($c, 0, $length) . '...' : $c;
    }

    /**
     * trims text to a space then adds ellipses if desired
     * @param string $input text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $strip_html if html tags are to be stripped
     * @return string
     */
    public static function trimWord($input, $length, $ellipses = true, $strip_html = true) {
      //strip tags, if desired
      if ($strip_html) {
        $input = strip_tags($input);
      }

      //no need to trim, already shorter than trim length
      if (strlen($input) <= $length) {
        return $input;
      }

      //find last space within length
      $last_space = strrpos(substr($input, 0, $length), ' ');
      $trimmed_text = substr($input, 0, $last_space);

      //add ellipses (...)
      if ($ellipses) {
        $trimmed_text .= '...';
      }

      return $trimmed_text;
    }

    public static function mapColumn($array, $column) {
      $result = array();
      foreach($array as $key=>$value){
        if(is_array($value)){
          $result[$key] = $value[$column];
        }elseif(is_object($value)){
          $result[$key] = $value->{$column};
        }
      }
      return $result;
    }

    public static function mapMethod($array, $method) {
      $result = array();
      $args = array_slice(func_get_args(), 2);
      foreach ($array as $key => $value) {
        $result[$key] = call_user_func_array(array($value, $method), $args);
      }
      return $result;
    }

    public static function highlight($needle, $haystack){
      return str_replace(" {$needle} ", " <strong>{$needle}</strong> ", $haystack);
    }

    public static function getFullUrl($url) {
      if(strpos($url, '://') === false) {
        return 'http://'.$url;
      } else {
        return $url;
      }
    }

    public static function fixImageUrl($src, $width, $height) {
      if(empty($src)) {
        return 'http://placehold.it/'.$width.'x'.$height.'&text=No+Image';
      } else {
        return $src;
      }
    }
  }
?>