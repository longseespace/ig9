<?php
/**
 * Author: Long Doan
 * Date: 8/29/12 10:55 AM
 */

$this->widget('widgets.elfinder.FinderWidget', array(
  'path' => Yii::app()->basePath . '/../uploads', // path to your uploads directory, must be writeable
  'url' => Yii::app()->baseUrl . '/uploads', // url to uploads directory
  'action' => $this->createUrl('admin/file/elfinder.connector') // the connector action (we assume we are pasting this code in the sitecontroller view file)
));
?>
<h1>Upload File</h1>

<div id="elfinder"></div>