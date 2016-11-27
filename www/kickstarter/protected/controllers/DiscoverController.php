<?php

class DiscoverController extends AbstractSiteController
{

  private $_model;

  public function init()
  {
    parent::init();   
  }
  
  public function actionCategory($slug=null) {
    $categories = Category::model()->findAll();
    $curCategory = Category::model()->findByAttributes(array('slug'=>$slug));
    $id = $curCategory?$curCategory->id:null;
    $projects['staff_pick'] = Project::model()->findAllStaffPicks($id, 3);
    $projects['popular'] = Project::model()->findAllPopular($id, 6);
    $projects['success'] = Project::model()->findAllSuccess($id, 3);
    $this->render('list', compact("categories", "projects"));
  }

  public function actionAll($slug=null, $filter = null) {
    $categories = Category::model()->findAll();
    $curCategory = Category::model()->findByAttributes(array('slug'=>$slug));

    $id = $curCategory?$curCategory->id:null;
    
    switch ($filter) {
      case 'staff-pick':
        $projects = Project::model()->findAllStaffPicks($id, null);
        $title = ___("Staff Picks");
        break;

      case 'popular':
        $projects = Project::model()->findAllPopular($id, null);
        $title = ___("Popular Now");
        break;

      case 'recent':
        $projects = Project::model()->findAllRecent($id, null);
        $title = ___("Recently Launched");
        break;

      case 'ending-soon':
        $projects = Project::model()->findAllEnding($id, null);
        $title = ___("Ending Soon");
        break;
      
      case 'most-funded':
        $projects = Project::model()->findAllMostFunded($id, null);
        $title = ___("Most Funded");
        break;


      default:
        $projects = Project::model()->findAllActive($id, null);
        break;
    }
    
    if ($title) {
      $cat_name = $curCategory?$curCategory->name:"";
      $title .= " / ".$cat_name;
    } else {
      $title = $curCategory?$curCategory->name:"";
    }

    $this->render('all', compact("categories", "projects", "curCategory", "title"));
    
  }

  public function actionFilter($filter, $slug=null) {
    $categories = Category::model()->findAll();

    $curCategory = Category::model()->findByAttributes(array('slug'=>$slug));

    $id = $curCategory?$curCategory->id:null;

    if ($id) {
      $data = Category::model()->findAllByAttributes(array('id'=>$id));
    } else {
      $data = $categories;
    }

    switch ($filter) {
      case 'staff-pick':
        $title = ___("Staff Picks");
        $entity = "staffPicksProjects";        
        break;
      
      case 'popular':
        $title = ___("Popular Right Now");
        $entity = "popularProjects";
        break;
      case 'recent':
        $title = ___("Recently Launched");
        $entity = "recentProjects";
        break;
      case 'ending-soon':
        $title = ___("Ending Soon");
        $entity = "endingProjects";
        break;
      case 'most-funded':
        $title = ___("Most Funded");
        $entity = "mostFundedProjects";
        break;
      default:
        # code...
        break;
    }

    $this->render('filter', compact("categories", "data", "entity", "curCategory", "title", "filter"));
  }

  
}