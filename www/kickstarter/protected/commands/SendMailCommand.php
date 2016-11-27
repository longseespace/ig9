<?php

class SendMailCommand extends CConsoleCommand
{
  var $mailer;

  public function init(){
    if (!$this->mailer) {
      $SM = Yii::app()->swiftMailer;
      $config = Yii::app()->params['mail'];
      $transport = $SM->smtpTransport()
        ->setHost($config['host'])
        ->setPort($config['port'])
        ->setEncryption($config['encryption'])
        ->setUsername($config['username'])
        ->setPassword($config['password']);

      $this->mailer = $SM->mailer($transport);
    }
  }

  public function run($args)
  {
    $SM = Yii::app()->swiftMailer;

    $mails = Email::model()->findAll('status = 0');
    foreach ($mails as $mail) {
      $content = $this->render($mail->template, compact('mail'));
      $message = $SM->newMessage($mail->subject)
                ->setFrom(array('info@ig9.vn' => 'ig9.vn'))
                ->setTo(array($mail->recipient))
                // ->setBody($content)
                ->addPart($content, 'text/html');

      $replacement[$mail->recipient] = (array) $mail->replacement;
      $decorator = new Swift_Plugins_DecoratorPlugin($replacement);
      $this->mailer->registerPlugin($decorator);
      // Send mail
      $mail->status = 1;
      $mail->update(array('status'));

      if ($this->mailer->send($message)) {
        $mail->status = 2;
        $mail->update(array('status'));
      }
      
    }
  }

  public function render($template, $data){
    $view_path = dirname(__FILE__).'/../views/mail/';
    if (strpos($template, '.php') === false) {
      $template = $template.'.php';
    }
    return parent::renderFile($view_path.$template, $data, true);
  }
}
