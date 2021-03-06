<?php

class NhongCommand extends CConsoleCommand
{

  public $project_id = 127;
  public $project_permalink = "http://ig9.vn/projects/hao-kiet-dung-hang-viet/127";
  public $email_template = 'project-nhong';
  public $email_subject = 'Dự án Hào kiệt dùng hàng Việt đã gọi vốn thành công!';

  public function init(){
    
  }

  public function run($args){
    $project = Project::model()->findByPk($this->project_id);
    $backers = UserProject::model()->findAll(array(
      'with'=>array(
        'user',
        'project'=>array(
          'select'=>false,
          'condition'=>'project_id=' . $this->project_id
        ),
      ),
      'group' => 't.user_id',
      'together'=>true,
    ));

    foreach ($backers as $backer) {
      $reward = false;
      foreach ($backer->user->transactions as $transaction) {
        if ($transaction->reward->project->id === $backer->project_id) {
          $reward = $transaction->reward;
          break;
        }
      };

      if (!$reward) {
        die('ERROR: No reward found');
      }

      $mail = new Email();
      $mail->template = $this->email_template;
      $mail->subject = $this->email_subject;
      $mail->recipient = $backer->user->email;
      $mail->status = 0;
      $mail->replacement = array(
        "{project-title}" => $project->title,
        "{project-permalink}" => $this->project_permalink,
        "{name}" => trim(array_shift(array_reverse(explode(" ",$backer->user->profile->fullname)))),
        "{project-owner}" => "Nhộng",
        "{reward}" => $reward->description
      );

      $mail->hash = md5(json_encode($mail->attributes));
      try {
        $mail->save();
      } catch (Exception $e) {

      }
    }
  }

}
