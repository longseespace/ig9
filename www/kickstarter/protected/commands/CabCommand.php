<?php

class CabCommand extends CConsoleCommand
{

  public $project_id = 128;
  public $project_permalink = "http://ig9.vn/projects/cab-image-generator-meme-rage-comic-maker-cabig/128";
  public $email_template = 'project-cab';
  public $email_subject = 'Dự án CAB Image Generator đã kết thúc!';

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
      $mail = new Email();
      $mail->template = $this->email_template;
      $mail->subject = $this->email_subject;
      $mail->recipient = $backer->user->email;
      $mail->status = 0;
      $name = empty($backer->user->profile->fullname) ? 'bạn' : trim(array_shift(array_reverse(explode(" ",$backer->user->profile->fullname))));
      $mail->replacement = array(
        "{project-title}" => $project->title,
        "{project-permalink}" => $this->project_permalink,
        "{name}" => $name,
        "{amount}" => __m($backer->amount)
      );

      $mail->hash = md5(json_encode($mail->attributes));
      try {
        $mail->save();
      } catch (Exception $e) {

      }
    }
  }

}
