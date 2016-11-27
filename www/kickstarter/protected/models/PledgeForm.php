<?php

class PledgeForm extends CFormModel {

  var $reward_id, $amount;

  public static function model($className=__CLASS__)  {
    return parent::model($className);
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('reward_id, amount', 'required'),
      array('reward_id, amount', 'checkAmount'),
      array('reward_id', 'compare', 'compareValue' => 0, 'operator' => '!=', 'message' => ___("You must choose a reward")),
      array('amount', 'filter', 'filter' => function($value){
        return m__($value);
      })
    );
  }

  public function checkAmount($attribute, $params)
  {
    if ($attribute === 'amount') {
      $amount = m__($this->amount);
      if ($this->reward_id > 0) {
        $minAmount = Reward::model()->findByPk($this->reward_id)->amount;

        if ($amount < $minAmount) {
          $this->addError('amount', ___('Sorry, you must pledge at least %s to select that reward.', __m($minAmount)));
        }
      }
    }
  }

}