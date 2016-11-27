<?php
namespace application\models\behaviors;

class MagicEmbedBehavior extends \CModelBehavior {

  protected $_embeddedDocuments = false;

  public function embedForeign($baseField, $id) {
    $owner = $this->owner;
    $embeddedOneEntries = $owner->embeddedOne();
    $owner->{$baseField} = $id;
    if(!empty($embeddedOneEntries)){
      foreach($embeddedOneEntries as $entry){
        if($baseField == $entry['baseField']){
          $class = $entry['foreignClass'];
          if(!empty($class)){
            $foreignModel = $class::model()->findByPk($id);
            if(!empty($foreignModel)){
              $embeddedClass = $entry['embeddedClass'];
              if(!empty($embeddedClass) && $embeddedClass != $class){
                $embeddedModel = self::cast($embeddedClass, $foreignModel);
              }else{
                $embeddedModel = $foreignModel;
              }
              $owner->{$entry['embeddedField']} = $embeddedModel;
            }
          }
          break;
        }
      }
    }
  }

  public function embedForeignArray($field, array $ids) {
    $owner = $this->owner;
    $embeddedManyEntries = $owner->embeddedMany();
    $owner->{$field} = array();
    if(!empty($embeddedManyEntries)){
      foreach($embeddedManyEntries as $entry){
        if($field == $entry['field']){
          $class = $entry['embeddedClass'];
          $criteria = new \EMongoCriteria;
          $ids = array_map(function($id){
            if(is_string($id)){
              $id = new \MongoID($id);
            }
            return $id;
          }, $ids);
          $criteria->addCond('_id', 'in', $ids);
          $foreignModels = $class::model()->findAll($criteria);
          $embeddedClass = $entry['embeddedClass'];
          if(!empty($embeddedClass) && $embeddedClass != $class){
            foreach($foreignModels as $model){
              $owner->{field}[] = self::cast($embeddedClass, $model);
            }
          }else{
            $owner->{$field} = $foreignModels;
          }
        }
      }
    }
  }

  public function pushForeignArray($field, $id) {
    $owner = $this->owner;
    $embeddedManyEntries = $owner->embeddedMany();
    $owner->{$field} = array();
    if(!empty($embeddedManyEntries)){
      foreach($embeddedManyEntries as $entry){
        if($field == $entry['field']){
          $class = $entry['embeddedClass'];
          $criteria = new \EMongoCriteria;
          $criteria->addCond('_id', 'in', $ids);
          $foreignModels = $class::model()->findAll($criteria);
          $owner->{$field} = $foreignModels;
        }
      }
    }
  }

  /**
   * Class casting
   *
   * @param string|object $destination
   * @param object $sourceObject
   * @return object
   */
  private static function cast($destination, $sourceObject)
  {
    if (is_string($destination)) {
      $destination = new $destination();
    }
    if ($sourceObject instanceof \CActiveRecord){
      return self::castActiveRecord($destination, $sourceObject);
    } else {
      return self::castMongoDocument($destination, $sourceObject);
    }
  }

  private static function castActiveRecord($destinationObject, $sourceObject){
    $attributes = $sourceObject->getAttributes();
    $destinationReflection = new \ReflectionObject($destinationObject);
    $destinationProperties = $destinationReflection->getProperties();
    foreach ($destinationProperties as $destinationProperty){
      if($destinationProperty->isPublic() && !$destinationProperty->isStatic()){
        $destinationProperty->setAccessible(true);
        $name = $destinationProperty->getName();
        if(isset($attributes[$name])){
          $destinationObject->{$name} = $attributes[$name];
        }
      }
    }
    return $destinationObject;
  }

  private static function castMongoDocument($destinationObject, $sourceObject){
    $sourceReflection = new \ReflectionObject($sourceObject);
    $destinationReflection = new \ReflectionObject($destinationObject);
    $sourceProperties = $sourceReflection->getProperties();
    foreach ($sourceProperties as $sourceProperty) {
      $sourceProperty->setAccessible(true);
      $name = $sourceProperty->getName();
      $value = $sourceProperty->getValue($sourceObject);
      if ($destinationReflection->hasProperty($name)) {
        $propDest = $destinationReflection->getProperty($name);
        $propDest->setAccessible(true);
        $propDest->setValue($destinationObject,$value);
      } else {
        try{
          $destinationObject->$name = $value;
        }catch(\CException $e){
        }
      }
    }
    return $destinationObject;
  }

  private static function getId($sourceObject){
    if($sourceObject instanceof \CActiveRecord){
      if(!empty($sourceObject->id)){
        return $sourceObject->id;
      }else{
        return 0;
      }
    }else{
      if(!empty($sourceObject->_id)){
        return $sourceObject->_id;
      }else{
        return null;
      }
    }
  }

}