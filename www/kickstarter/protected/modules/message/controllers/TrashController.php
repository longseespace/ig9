<?php

class TrashController extends Controller
{
	public $defaultAction = 'all';

	public function actionAll() {
		$messagesAdapter = Message::getAdapterForTrash(Yii::app()->user->getId());
		$pager = new CPagination($messagesAdapter->totalItemCount);
		$pager->pageSize = 5;
		$messagesAdapter->setPagination($pager);

		$this->render(Yii::app()->getModule('message')->viewPath . '/inbox', array(
			'messagesAdapter' => $messagesAdapter
		));
	}

}
