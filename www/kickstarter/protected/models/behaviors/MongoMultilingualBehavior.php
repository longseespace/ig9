<?php

class MongoMultilingualBehavior extends EMongoDocumentBehavior {

  public $localizedAttributes = array();

  public $localizedWrapperField = 'i18n';

  public $languages;

  public $defaultLanguage;

  public function afterEmbeddedDocsInit($event)
  {
    $this->parseExistingArray();
  }

  public function localized(){

  }

  public function __get($key){
    try {
      return parent::__get($name);
    } catch (CException $e) {
      if ($this->hasLangAttribute($name)) {
        return $this->getLangAttribute($name);
      } else {
        throw $e;
      }
    }
  }

  public function __set($key, $value){
    try {
      parent::__set($name, $value);
    } catch (CException $e) {
      if ($this->hasLangAttribute($name)) {
        $this->setLangAttribute($name, $value);
      } else {
        throw $e;
      }
    }
  }

  public function __isset($name){
    if (! parent::__isset($name)) {
      return ($this->hasLangAttribute($name));
    } else {
      return true;
    }
  }

  public function canGetProperty($name){
    return parent::canGetProperty($name) or $this->hasLangAttribute($name);
  }

  public function canSetProperty($name){
    return parent::canSetProperty($name) or $this->hasLangAttribute($name);
  }

  public function hasProperty($name){
    return parent::hasProperty($name) or $this->hasLangAttribute($name);
  }

}