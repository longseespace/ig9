<?php

class DraftController extends Controller
{
	public $defaultAction = 'all';

	public function actionAll() {
		$messagesAdapter = Message::getAdapterForDraft(Yii::app()->user->getId());
		$pager = new CPagination($messagesAdapter->totalItemCount);
		$pager->pageSize = 5;
		$messagesAdapter->setPagination($pager);

		$this->render(Yii::app()->getModule('message')->viewPath . '/inbox', array(
			'messagesAdapter' => $messagesAdapter
		));
	}

	public function actionDelete(){
		if (!isset($_POST['message_ids'])) {
			die('0');
		}

		$message_ids = $_POST['message_ids'];
		$messages = Message::model()->findAllByPk($message_ids);

		foreach ($messages as $message) {
			$message->deleted_by = 'sender';
			$message->update();
		}

		die('1');
	}
}
