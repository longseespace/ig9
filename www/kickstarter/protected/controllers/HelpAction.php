<?php
/**
 * Author: Long Doan
 * Date: 9/10/12 4:54 PM
 */
class HelpAction extends CAction {

  public function run($id = 0) {
    $file = $this->getId();
    if (Yii::app()->language === 'vn') $file .= '-vn';
    $file .= '/' . $id;
    if ($this->getController()->getViewFile($file)) {
      $this->getController()->render($file);
    } else {
      $this->getController()->render($this->getId() . '/' . 'default');
    }
  }
}

?>
