<?php
  class DClientScript extends CClientScript {

    public function registerScriptFile($url,$position=null){
      if($position === CClientScript::POS_LOAD || $position === CClientScript::POS_READY){
        $this->registerScript($url, 'jQuery(\'head\').append(\'\<script type="text/javascript" src="'.$url.'"\>\<\/script\>\');', $position);
      }else{
        parent::registerScriptFile($url, $position);
      }
    }

  }
?>