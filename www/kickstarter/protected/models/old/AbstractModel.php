<?php


abstract class AbstractModel extends \EMongoDocument {

  public $created;
  public $modified;
  private $_embeddedDocuments;
  private $_behaviors;

  final public function embeddedDocuments(){
    if($this->_embeddedDocuments === null){
      $this->_embeddedDocuments = array();
      $embeddedOneEntries = $this->embeddedOne();
      if(!empty($embeddedOneEntries)){
        foreach($embeddedOneEntries as $entry){
          $this->_embeddedDocuments[$entry['embeddedField']] = empty($entry['embeddedClass']) ?  $entry['foreignClass'] : $entry['embeddedClass'];
        }
      }

      $additionEmbeddedDocuments = $this->additionEmbeddedDocuments();
      if(!empty($additionEmbeddedDocuments)){
        $this->_embeddedDocuments = array_merge($this->embeddedDocuments, $additionEmbeddedDocuments);
      }
    }

    return $this->_embeddedDocuments;
  }

  public function additionEmbeddedDocuments(){
    return array();
  }

  public function embeddedOne(){
    return array();
  }

  public function embeddedMany(){
    return array();
  }

  public function behaviors(){
    if(!isset($this->_behaviors)){
      $this->_behaviors = array(
        'Timestamp' => array(
          'class'=>'\application\models\behaviors\TimestampBehavior'
        ),
        'MagicEmbed' => array(
          'class'=>'\application\models\behaviors\MagicEmbedBehavior'
        )
      );

      $embeddedManyEntries = $this->embeddedMany();
      if(!empty($embeddedManyEntries)){
        foreach($embeddedManyEntries as $entry){
          $this->_behaviors[] = array(
            'class'=>'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
            'arrayPropertyName'=>$entry['field'],
            'arrayDocClassName'=>$entry['embeddedClass']
          );
        }
      }
    }

    return $this->_behaviors;
  }

  public function __set($name, $value){
    if($name == 'id'){
      $this->_id = $value;
    }else{
      parent::__set($name, $value);
    }
  }

  public function __get($name){
    if($name == 'id' && !empty($this->_id)){
      return $this->_id;
    }else{
      return parent::__get($name);
    }
  }

}