<?php


class Taxonomy extends AbstractModel {

  public $type;
  public $name;
  public $slug;

  /**
   * This method have to be defined in every Model
   * @return string MongoDB collection name, witch will be used to store documents of this model
   */
  public function getCollectionName()
  {
    return 'taxonomies';
  }

  /**
   * This method have to be defined in every model, like with normal CActiveRecord
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
}