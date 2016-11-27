<?php 

$module = Yii::app()->getModule('message');
$user = Yii::app()->user;

$inboxUnread = $module->getCountUnreadedMessages($user->id);

$labelSuffix['inbox'] = $inboxUnread ? '(' . $inboxUnread . ')' : '';

$this->widget('application.widgets.Menu', array(
  'linkLabelWrapper' => 'span',
  'submenuHtmlOptions' => array('class' => 'sub'),
  'items' => array(
    // IMPORTANT: you need to specify url as 'controller/action',
    // not just as 'controller' even if default action is used.
    array(
      'label' => ___('Inbox').' '.$labelSuffix['inbox'], 
      'url' => array('/message/inbox'),
      'itemOptions' => array('class' => 'inbox')
    ),
    array(
      'label' => ___('Sent Message'), 
      'url' => array('/message/sent'),
      'itemOptions' => array('class' => 'sent'),
    ),
    array(
      'label' => ___('Drafts'),
      'url' => array('/message/draft'),
      'itemOptions' => array('class' => 'draft'),
    ),
    array(
      'label' => ___('Trash'),
      'url' => array('/message/trash'),
      'itemOptions' => array('class' => 'trash'),
    ),
  ),
  'htmlOptions' => array(
    'class' => 'actions nav',
  ),
));
?>


<?php if(Yii::app()->user->hasFlash('messageModule')): ?>
	<div class="success">
		<?php echo Yii::app()->user->getFlash('messageModule'); ?>
	</div>
<?php endif; ?>
