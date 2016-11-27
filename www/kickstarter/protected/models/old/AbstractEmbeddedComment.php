<?php


abstract class AbstractEmbeddedComment extends AbstractEmbeddedModel {

  public $userId;
  public $content;

  public function embeddedOne(){
    return array(
      array(
        'baseField' => 'userId',
        'embeddedField' => 'user',
        'embeddedClass' => '\application\models\CommentEUser',
        'foreignClass' => '\User'
      )
    );
  }

}

class CommentEUser extends AbstractEmbeddedModel {
  public $_id;
  public $email;
  public $username;
}