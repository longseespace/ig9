<?php
namespace application\models\behaviors;

class TimestampBehavior extends \EMongoDocumentBehavior {

  /**
   * EMongoDocument::beforeSave
   * @return
   */
  public function beforeSave($event) {
    $model = $this->owner;
    $now = time();
    if($model->getIsNewRecord()){
      $model->created = $now;
    }
    $model->modified = $now;
    return parent::beforeSave($event);
  }

}