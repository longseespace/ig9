<?php

class DefaultController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
      return array('noAccess');
    }

    public function filterNoAccess($filterChain) {
      $this->redirect($this->url('user', 'profile'));
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
		        'condition'=>'status>'.User::STATUS_BANED,
		    ),
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('/user/index',array(
			'dataProvider'=>$dataProvider,
		));
	}

}