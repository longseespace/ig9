<?php

class ComposeController extends Controller
{

	public $defaultAction = 'send';

	public function actionSend($to = '') {
		$messagesAdapter = Message::getAdapterForInbox(Yii::app()->user->getId());
		$pager = new CPagination($messagesAdapter->totalItemCount);
		$pager->pageSize = 5;
		$messagesAdapter->setPagination($pager);

		$this->render(Yii::app()->getModule('message')->viewPath . '/inbox', array(
			'messagesAdapter' => $messagesAdapter,
			'composing' => true,
			'to' => $to
		));
	}
}
