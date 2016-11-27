<?php

class P {

  private $_attributes = array("foo" => "bar");

  public function dkm($attributes){
    $this->_attributes = array_merge($this->_attributes, $attributes);
  }

  public function setAttributes($attributes){
    $this->dkm($attributes);
  }

  public function getAttributes(){
    return $this->_attributes;
  }

  public function test(){
    return $this->_attributes;
  }

}

class C extends  P {

  private $_attributes = array("foo" => "bar2");

  public function getAttributes(){
    return $this->_attributes;
  }

  public function setAttributes($attributes){
    $this->dkm($attributes);
  }

}

$child = new C;
$child->setAttributes(array("foo" => "bar3"));
var_dump($child->getAttributes());
var_dump($child->test());
die();

?>