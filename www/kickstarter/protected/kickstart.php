<?php

/**
 * i18n wrappers
 * @param string $message
 * @param mixed $params (string, array, varargs)
 * @param string $context
 * @return string Translated phrase
 */
function ___()
{
  $args = func_get_args();
  $message = $args[0];
  $count = substr_count($message, '%s');

  if (!$count) {
    $params = array();
    $context = isset($args[1]) ? $args[1] : 'app';
  } else {
    if (is_array($args[1])) {
      $params = $args[1];
      $context = isset($args[2]) ? $args[2] : 'app';
    } else {
      $params = array();
      for ($i=1; $i <= $count; $i++) {
        $params[] = $args[$i];
      }
      $context = isset($args[$i]) ? $args[$i] : 'app';
    }
  }

  return call_user_func_array("sprintf", array_merge(array(Yii::t($context, $message, array())), $params));
}


function __()
{
  echo call_user_func_array('___',func_get_args());
}

/**
 * i18n wrappers for date
 */
function __d($value, $format = 'd/m/Y'){
  if(!is_int($value)){
    $value = strtotime($value);
  }
  return date($format, $value);
}
function _d($value, $format = 'd/m/Y'){
  echo __d($value, $format);
}

function d__($value){
  $old_day = 1354482989;
  if(!is_int($value)){
    $value = strtotime($value);
  }
  if ($value < $old_day) {
    $value = time();
  }
  return date('Y-m-d', $value);
}
function d_($value){
  echo d__($value);
}

/**
 * i18n wrappers for time
 */
function __t($value){
  return date('h:i:s A', $value);
}
function _t($value){
  echo __t($value);
}

/**
 * i18n wrapper for datetime
 */
function __dt($value){
  return date('d/m/Y h:i:s A', $value);
}
function _dt($value){
  echo __dt($value);
}

/**
 * i18n wrapper for number
 */
function __n($value){
  return number_format($value,null,',','.');
}
function _n($value){
  echo __n($value);
}

/**
 * i18n wrapper for money
 */
function __m($value, $suffix = '&#273;'){
  return number_format($value,null,',','.').$suffix;
}
function _m($value, $suffix = '&#273;'){
  echo __m($value);
}


/**
 * i18n wrapper for percentage
 */
function __p($value, $limit = false){
  return ($value>1&&$limit)?'100%':round($value*100).'%';
}
function _p($value, $limit = false){
  echo __p($value, $limit);
}

/**
 * i18n wrapper for date diff
 */
function __dd($day1, $day2 =null){
  if ($day2) {
    $intervalo = date_diff(date_create($day2), date_create($day1));
  } else {
    $intervalo = date_diff(date_create(), date_create($day1));
  }

  return $intervalo->days;
}
function _dd($day1, $day2 =null){
  echo __dd($day1, $day2);
}

function m__($value, $suffix = '&#273;'){
  return intval(str_replace(array(',', '.', $suffix, ' '), '', $value));
}
function m_($value, $suffix = '&#273;'){
  echo m__($value);
}


/**
 * array_merge_recursive does indeed merge arrays, but it converts values with duplicate
 * keys to arrays rather than overwriting the value in the first array with the duplicate
 * value in the second array, as array_merge does. I.e., with array_merge_recursive,
 * this happens (documented behavior):
 *
 * array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
 *     => array('key' => array('org value', 'new value'));
 *
 * array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
 * Matching keys' values in the second array overwrite those in the first array, as is the
 * case with array_merge, i.e.:
 *
 * array_merge_recursive_distinct(array('key' => 'org value'), array('key' => 'new value'));
 *     => array('key' => 'new value');
 *
 * Parameters are passed by reference, though only for performance reasons. They're not
 * altered by this function.
 *
 * @param array $array1
 * @param mixed $array2
 * @author daniel@danielsmedegaardbuus.dk
 * @return array
 */
function &array_merge_recursive_distinct(array &$array1, &$array2 = null)
{
  $merged = $array1;

  if (is_array($array2)){
    foreach ($array2 as $key => $val){
      if(is_int($key)){
        $merged[] = $val;
      }else{
        if (is_array($array2[$key])){
          $merged[$key] = is_array($merged[$key]) ? array_merge_recursive_distinct($merged[$key], $array2[$key]) : $array2[$key];
        }else{
          $merged[$key] = $val;
        }
      }
    }

  }


  return $merged;
}

?>