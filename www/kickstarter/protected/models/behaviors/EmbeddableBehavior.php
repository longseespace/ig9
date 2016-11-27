<?php
namespace application\models\behaviors;

class EmbeddableBehavior extends \CModelBehavior {

  protected $_owner=null;

  public function toArray(){
    $model = $this->owner;
    if($model instanceof CActiveRecord){
      return $model->getAttributes();
    }else{
      return array();
    }
  }

  public function setOwner($owner){
    $this->_owner = $owner;
  }

}