<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 11:53 AM
 */
abstract class AbstractSQLModel extends CActiveRecord {

  public static function model($className=__CLASS__)  {
    return parent::model($className);
  }

  /**
   * Get or set the data of this model
   * @param array $data
   * @return array attributes on get, $this on set
   */
  public function data(array $data = array()) {
    if (!empty($data)) {
      foreach (array_intersect_key($data, $this->attributes) as $x => $y) {
        $this->$x = $y;
      }
      return $this;
    }
    return $this->attributes;
  }

}

?>
