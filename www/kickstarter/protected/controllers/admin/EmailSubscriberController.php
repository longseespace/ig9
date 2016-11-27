<?php

class EmailSubscriberController extends AbstractAdminController
{

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
    $models = new CActiveDataProvider('EmailSubscriber', array(
      'criteria'=>array(
      ),
      'pagination'=> array(
        'pageSize'=> 10,
      ),
    ));
    $this->render('index', compact('models'));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/emailsubscriber'));
	}

	public function actionExport() {
		$data = EmailSubscriber::model()->findAll();
		Yii::import('application.extensions.phpexcel.JPhpExcel');
		$xls = new JPhpExcel('UTF-8', false, 'Subscriber List');
		$xls->addArray($data);
		$xls->generateXML('Email subscriber list'.date('d-m-Y'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = EmailSubscriber::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}