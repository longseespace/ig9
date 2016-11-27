<?php

Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js', CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js', CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerCSSFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css');

$publish = Yii::app()->assetManager->publish( Yii::getPathOfAlias('widgets.elfinder.assets'));
Yii::app()->clientScript->registerCSSFile($publish .  '/css/elfinder.full.css');
Yii::app()->clientScript->registerCSSFile($publish .  '/css/theme.css');

$publish = Yii::app()->assetManager->publish( Yii::getPathOfAlias('widgets.elfinder.assets.js') .  '/elfinder.full.js');
Yii::app()->clientScript->registerScriptFile($publish, CClientScript::POS_BEGIN);

$script = "var elf = $('".$this->selector."').elfinder({
					url : '".$this->action."'  // connector URL (REQUIRED)
				}).elfinder('instance');";
Yii::app()->clientScript->registerScript('elfinder', $script, CClientScript::POS_READY);

?>