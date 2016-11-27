<?php

class InboxController extends Controller
{
	public $defaultAction = 'all';

	public function actionAll() {
		$messagesAdapter = Message::getAdapterForInbox(Yii::app()->user->getId());
		$pager = new CPagination($messagesAdapter->totalItemCount);
		$pager->pageSize = 5;
		$messagesAdapter->setPagination($pager);

		$this->render(Yii::app()->getModule('message')->viewPath . '/inbox', array(
			'messagesAdapter' => $messagesAdapter
		));
	}

	public function actionView($id){
		$messagesAdapter = Message::getAdapterForInbox(Yii::app()->user->getId());
		$pager = new CPagination($messagesAdapter->totalItemCount);
		$pager->pageSize = 5;
		$messagesAdapter->setPagination($pager);

		$theMessage = Message::model()->findByPk($id);
		if ($theMessage->sender_id != Yii::app()->user->getId() && Yii::app()->user->getId() != $theMessage->receiver_id) {
			$theMessage = false;

			$this->addJSVars(array('notfound' => true));
		}

		$this->render(Yii::app()->getModule('message')->viewPath . '/inbox', array(
			'messagesAdapter' => $messagesAdapter,
			'theMessage' => $theMessage
		));
	}

	public function actionMarkAsRead(){
		if (!isset($_POST['message_ids'])) {
			die('0');
		}

		$message_ids = $_POST['message_ids'];
		$messages = Message::model()->findAllByPk($message_ids);

		foreach ($messages as $message) {
			$message->is_read = 1;
			$message->update();
		}

		echo json_encode($message_ids);

		die();
	}

	public function actionMarkAsUnread(){
		if (!isset($_POST['message_ids'])) {
			die('0');
		}

		$message_ids = $_POST['message_ids'];
		$messages = Message::model()->findAllByPk($message_ids);

		foreach ($messages as $message) {
			$message->is_read = 0;
			$message->update();
		}

		echo json_encode($message_ids);

		die();
	}

	public function actionDelete(){
		if (!isset($_POST['message_ids'])) {
			die('0');
		}

		$message_ids = $_POST['message_ids'];
		$messages = Message::model()->findAllByPk($message_ids);

		foreach ($messages as $message) {
			if ($message->sender_id == Yii::app()->user->id) {
				if (!$message->deleted_by) {
					$message->deleted_by = Message::DELETED_BY_SENDER;
				} else if ($message->deleted_by == Message::DELETED_BY_SENDER) {
					$message->deleted_by = Message::DELETED_BY_SENDER_EXPLICIT;
				} else {
					$message->deleted_by = Message::DELETED_BY_BOTH;
				}
			} else {
				if (!$message->deleted_by) {
					$message->deleted_by = Message::DELETED_BY_RECEIVER;
				} else if ($message->deleted_by == Message::DELETED_BY_RECEIVER) {
					$message->deleted_by = Message::DELETED_BY_RECEIVER_EXPLICIT;
				} else {
					$message->deleted_by = Message::DELETED_BY_BOTH;
				}				
			}
			
			$message->update();
		}

		echo json_encode($message_ids);

		die();
	}
	
	public function actionCompose(){
		if (!isset($_POST['Message'])) {
			die('0');
		}

		$request = Yii::app()->request;
		if ($request->getPost('id', 0) > 0) {
			$message = Message::model()->findByPk($request->getPost('id'));
		} else {
			$message = new Message;	
		}
		
		if ($post = $request->getPost('Message')) {
			$receiverName = $request->getPost('receiver');
		  $message->subject = $post['subject'];
		  $message->body = $post['body'];
			$message->sender_id = Yii::app()->user->getId();

			$kienNgu = User::model()->findByAttributes(array('username' => $receiverName));

			if (!$kienNgu) {
				die('0');
			}
			$message->receiver_id = $kienNgu->id;

			if ($message->save()) {
				echo '1';
			} else  {
				echo '0';
			}
		} else {

		}

		die();
	}


	public function actionSave(){
		if (!isset($_POST['Message'])) {
			die('0');
		}

		$request = Yii::app()->request;
		if ($request->getPost('id', 0) > 0) {
			$message = Message::model()->findByPk($request->getPost('id'));
		} else {
			$message = new Message;	
		}

		if ($post = $request->getPost('Message')) {

		  $message->subject = $post['subject'];
		  $message->body = $post['body'];
			$message->sender_id = Yii::app()->user->getId();
			$message->receiver_id = 0;

			if ($message->save()) {
				echo $message->id;
			} else  {
				echo '0';
			}
		} else {
			echo '0';
		}

		die();
	}




}
