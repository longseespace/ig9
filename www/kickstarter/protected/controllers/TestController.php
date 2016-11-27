<?php


class TestController extends AbstractSiteController
{

  public function actionIndex() {
    I18nShortHand::generatePoFile();
  }

  public function actionAddRewards() {
    $reward = new Reward();
    $reward->project_id = 1;
    $reward->title = '';
    $reward->description = 'Eternal gratitude. You\'ll forever know you were part of changing how mobile apps are built.';
    $reward->amount = 1000;
    $reward->delivery_time = '2013-05-04';
    $reward->backer_limit = -1;
    $reward->backer_count = 16;
    $reward->save();

    $reward = new Reward();
    $reward->project_id = 1;
    $reward->title = '';
    $reward->description = 'Support Pixate. Your name with a link will be listed as a supporter on the Pixate web site and we\'ll keep you up-to-date on all things Pixate.';
    $reward->amount = 5000;
    $reward->delivery_time = '2013-05-04';
    $reward->backer_limit = -1;
    $reward->backer_count = 26;
    $reward->save();

    $reward = new Reward();
    $reward->project_id = 1;
    $reward->title = '';
    $reward->description = 'You\'ll get listed as a supporter and get a chance to use Pixate before it ships with access to a final beta prior to the 1.0 launch.';
    $reward->amount = 10000;
    $reward->delivery_time = '2013-05-04';
    $reward->backer_limit = -1;
    $reward->backer_count = 26;
    $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'Can\'t wait and want to start using Pixate asap? Get early access to monthly betas soon after the campaign ends.';
     $reward->amount = 20000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = -1;
     $reward->backer_count = 44;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'Get early access to monthly betas PLUS a super-awesome, limited-edition Pixate t-shirt just for our Kickstart backers. (All backers at this pledge level and above will receive a t-shirt. **International pledgers please add $10 for shipping to your pledge.)';
     $reward->amount = 35000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = -1;
     $reward->backer_count = 35;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'VISUALIZER Get a license to the desktop and mobile versions of Pixate Visualizer only. Get early access to monthly betas PLUS a super-awesome, limited-edition Pixate t-shirt just for our Kickstart backers. (All backers at this pledge level and above will receive a t-shirt. **International pledgers please add $10 for shipping to your pledge.)';
     $reward->amount = 40000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 10;
     $reward->backer_count = 10;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'Can\'t wait and want to start using Pixate asap? Get early access to monthly betas soon after the campaign ends as well as early adopter pricing when we ship.';
     $reward->amount = 50000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = -1;
     $reward->backer_count = 10;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'SMASHING DEAL Receive one license to the Pixate Engine ($299 MSRP) when it ships and a limited edition t-shirt. (This level does not include any betas.)';
     $reward->amount = 69000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 99;
     $reward->backer_count = 67;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'FIREBALLED Receive the final beta before the product ships and one license to the Pixate Engine ($299 MSRP). And a limited edition t-shirt, of course.';
     $reward->amount = 79000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 99;
     $reward->backer_count = 99;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'TITANIUM SPECIAL Here\'s your chance to make sure our Appcelerator Titanium support happens. Pledge and receive a license to the Pixate Engine ($299 MSRP) as well as early monthly betas.';
     $reward->amount = 99000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 99;
     $reward->backer_count = 67;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'EARLY BIRDS Help us get started! One license to the Pixate Engine, $299 retail. Plus monthly betas.';
     $reward->amount = 99000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 99;
     $reward->backer_count = 99;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'One license to the Pixate Engine plus monthly beta access.';
     $reward->amount = 149000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = -1;
     $reward->backer_count = 0;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'One license to the Pixate Suite plus WEEKLY beta access.';
     $reward->amount = 250000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 35;
     $reward->backer_count = 4;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'One license to the Pixate Suite plus WEEKLY beta access.';
     $reward->amount = 250000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 35;
     $reward->backer_count = 4;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'One license to the Pixate Suite plus weekly beta access. Also 1 FREE major update to Pixate (i.e. 1.x to 2.x) and priority email support for 1 year.';
     $reward->amount = 499000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 20;
     $reward->backer_count = 1;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'CORPORATE SPONSOR You will be prominently featured on our home page for a year and you will receive 20 Pixate Suite licenses. This is your chance to get in front of cutting edge mobile developers.';
     $reward->amount = 5000000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 3;
     $reward->backer_count = 0;
     $reward->save();

     $reward = new Reward();
     $reward->project_id = 1;
     $reward->title = '';
     $reward->description = 'INTEGRATION PARTNER We will work with your engineering team to integrate your products/services with Pixate\'s. This could lead to a re-sale/OEM deal or other deep integration. You can also help define features that further enhance this opportunity. Of course you\'ll also be prominently featured on our home page, for a year, as a sponsor of the project.';
     $reward->amount = 10000000;
     $reward->delivery_time = '2013-05-04';
     $reward->backer_limit = 4;
     $reward->backer_count = 3;
     $reward->save();
  }

  public function actionPayment() {
    $payment = new Payment();
    $payment->setGateway('onepay_noidia');
    $url = $payment->buildRedirectUrl(array(
      'amount' => 10000,
      'reward_id' => 8
    ));
    $this->redirect($url);
  }

  public function actionProject(){
    $project = Project::model()->findByPk(1);
    var_dump($project->attributes);
    $project->setAttributes(array("title" => "foo"));
    var_dump($project->attributes);
    die();
  }

  public function actionCategoriesAdd(){
    $category = new Category();
    $category->name = "Art";
    $category->slug = "art";
    $category->save();

    $category = new Category();
    $category->name = "Comics";
    $category->slug = "comics";
    $category->save();

    $category = new Category();
    $category->name = "Dance";
    $category->slug = "dance";
    $category->save();

    $category = new Category();
    $category->name = "Design";
    $category->slug = "design";
    $category->save();

    $category = new Category();
    $category->name = "Fashion";
    $category->slug = "fashion";
    $category->save();

    $category = new Category();
    $category->name = "Film & Video";
    $category->slug = "film-video";
    $category->save();

    $category = new Category();
    $category->name = "Food";
    $category->slug = "food";
    $category->save();

    $category = new Category();
    $category->name = "Games";
    $category->slug = "games";
    $category->save();

    $category = new Category();
    $category->name = "Music";
    $category->slug = "music";
    $category->save();

    $category = new Category();
    $category->name = "Photography";
    $category->slug = "photography";
    $category->save();

    $category = new Category();
    $category->name = "Publishing";
    $category->slug = "publishing";
    $category->save();

    $category = new Category();
    $category->name = "Technology";
    $category->slug = "technology";
    $category->save();

    $category = new Category();
    $category->name = "Theater";
    $category->slug = "theater";
    $category->save();
  }

}