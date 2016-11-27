<?php

class FeedbackController extends Controller
{
	public function actionAdd(){

		$request = Yii::app()->request;
		
		if ($request->getPost('id', 0) > 0) {
			$feedback = Feedback::model()->findByPk($request->getPost('id'));
		} else {
			$feedback = new Feedback;
		}

		$feedback->score = $request->getPost('score', 10);
		$feedback->website_message = $request->getPost('website_message', '');
		$feedback->product_message = $request->getPost('product_message', '');
		$feedback->service_message = $request->getPost('service_message', '');
		$feedback->payment_message = $request->getPost('payment_message', '');
		$feedback->other_message = $request->getPost('other_message', '');
		$feedback->url = $request->getPost('url', '/');
		$feedback->email = $request->getPost('email', '');
		$feedback->user_agent = $request->userAgent;
		$feedback->ip = $request->userHostAddress;

		if ($feedback->save()) {
			echo $feedback->id;
		} else {
			echo 0;
		}

		Yii::app()->end();
	}
}