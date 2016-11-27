<?php
$baseUrl = $this->assetsUrl;
$this->pageTitle = "Create New Project — " . Yii::app()->name;
?>

<div class="container">
  <div id="main">
    <div class="project_edit_guidelines">
      <h3>
        <strong><?php __("Project Guidelines") ?></strong>
      </h3>
      <p>
        <?php __("IG9 is a funding platform for creative projects — everything from traditional forms of art (like theater and music) to contemporary forms (like design and games). These guidelines explain IG9’s focus. Projects violating these guidelines will not be allowed to launch.") ?>
      </p>
      <p>
        <?php __("Note that as you go through the site you may find past projects on IG9 that conflict with these rules. We’re making tweaks as we learn and grow. Thanks for reading!") ?>
      </p>
      <div class="guidelines">
        <div class="project_guidelines">
          <ul class="list-guidelines">
            <li>
              <h4>1.<?php __(" Funding for <em>projects</em> only.") ?></h4> <?php __("A project has a clear goal, like making an album, a book, or a work of art. A project will eventually be completed, and something will be produced by it. A project is not open-ended. Starting a business, for example, does not qualify as a project.") ?>
            </li>
            <li>
              <h4>2. <?php __("Projects must fit IG9’s categories.") ?></h4> <?php __("We currently support projects in the categories of Art, Comics, Dance, Design, Fashion, Film, Food, Games, Music, Photography, Publishing, Technology, and Theater.") ?>
              <p>
                <strong><?php __("Design and Technology projects have a few additional guidelines.") ?></strong> <?php __("If your project is in either of these categories, be sure to review them carefully.")?> <a href="#more-guidelines-container" id="view-guidelines" name="view-guidelines" onclick="javascript:$('#more-guidelines-container').toggle()"><?php __("View Design and Technology requirements") ?></a>
              </p>
              <div id="more-guidelines-container" style="display:none">
                <p>
                  <?php __("IG9 requires additional information from Design and Technology projects so backers can make informed decisions about the projects they support. These requirements include detailed information about the creator’s background and experience, a manufacturing plan (for hardware projects), and a functional prototype.") ?>
                </p>
                <p>
                  <?php __("Additionally, not everything that involves design or technology is permitted on IG9. While there is some subjectivity in these rules, we’ve adopted them to maintain our focus on creative projects.") ?>
                </p>
                <ul>
                  <li>
                    <strong><?php __("Projects, projects, projects.") ?></strong> <?php __("As in all categories, IG9 is for projects that can be completed, not things that require maintenance to exist. This means no e-commerce sites, web businesses, or social networking sites. (Yes, this means IG9 wouldn’t be allowed on IG9. Funny, but true.)") ?>
                  </li>
                  <li>
                    <strong><?php __("D.I.Y.") ?></strong> <?php __("We love projects from the hacker and maker communities (weekend experiments, 3D printers, CNC machines), and projects that are open source (hardware and software). Software projects should be run by the developers themselves.") ?>
                  </li>
                  <li>
                    <strong><?php __("Form as well as function.") ?></strong> <?php __("IG9 is a place for products with strong aesthetics. Think something you would find in a design store, not “As-Seen-On-TV” gizmos.") ?>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <h4>3. <?php __("Prohibited uses:") ?></h4>
              <ul>
                <li>
                  <strong><?php __('No "fund my life" projects.') ?></strong> <?php __("Examples include projects to pay tuition or bills, go on vacation, or buy a new camera.") ?>
                </li>
                <li>
                  <strong><?php __("Prohibited content.") ?></strong> <?php __("There are some things we just don't allow on IG9.") ?> <a href="#prohibited-container" id="view-prohibited" name="view-prohibited" onclick="javascript: $('#prohibited-container').toggle()"><?php __("View prohibited items and subject matter") ?></a>
                  <div id="prohibited-container" style="display:none">
                    <ul class="prohibited_projects">
                      <li><?php __("Alcohol (prohibited as a reward)") ?>
                      </li>
                      <li><?php __("Baby products") ?>
                      </li>
                      <li><?php __("Contests (entry fees, prize money, within your project to encourage support, etc)") ?>
                      </li>
                      <li><?php __("Cosmetics") ?>
                      </li>
                      <li><?php __("Coupons, discounts, and cash-value gift cards") ?>
                      </li>
                      <li><?php __("Drugs, drug-like substances, drug paraphernalia, tobacco, etc") ?>
                      </li>
                      <li><?php __("Electronic surveillance equipment") ?>
                      </li>
                      <li><?php __("Financial incentives (ownership, share of profits, repayment/loans, etc)") ?>
                      </li>
                      <li><?php __("Firearms, weapons, and knives") ?>
                      </li>
                      <li><?php __("Health and personal care products") ?>
                      </li>
                      <li><?php __("Heating and cooling products") ?>
                      </li>
                      <li><?php __("Home improvement products") ?>
                      </li>
                      <li><?php __("Infomercial or As-Seen-on-TV type products") ?>
                      </li>
                      <li><?php __("Medical and safety-related products") ?>
                      </li>
                      <li><?php __("Multilevel marketing and pyramid programs") ?>
                      </li>
                      <li><?php __("Nutritional supplements") ?>
                      </li>
                      <li><?php __("Offensive material (hate speech, inappropriate content, etc)") ?>
                      </li>
                      <li><?php __("Pet supplies") ?>
                      </li>
                      <li><?php __("Pornographic material") ?>
                      </li>
                      <li><?php __("Projects endorsing or opposing a political candidate") ?>
                      </li>
                      <li><?php __("Projects promoting or glorifying acts of violence") ?>
                      </li>
                      <li><?php __("Projects using IG9 simply to sell existing inventory") ?>
                      </li>
                      <li><?php __("Raffles, lotteries, and sweepstakes") ?>
                      </li>
                      <li><?php __("Real estate") ?>
                      </li>
                      <li><?php __("Rewards in bulk quantities (more than ten of an item)") ?>
                      </li>
                      <li><?php __("Rewards not directly produced by the project or its creator (no offering things from the garage, repackaged existing products, weekends at the resort, etc)") ?>
                      </li>
                      <li><?php __("Self-help books, DVDs, CDs, etc") ?>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <p>
          <?php __("Have questions?") ?> <a href="mailto:info@ig9.vn" id="" name=""><?php __("Drop us a line") ?></a>.
        </p>
      </div>
    </div>
    <form id="continue" name="continue" method="post">
      <input class="checkbox" id="guidelines_accept" name="accept" type="checkbox" value="1"> 
      <label class="unselected" for="guidelines_accept"><?php __("I understand that in order to launch, my project must meet the Project Guidelines and I must meet eligibility requirements.") ?></label> <a href="<?php echo $this->createUrl('project/basics') ?>" id="start" class="start button-positive disabled"><?php __("Start Your Project") ?></a>
    </form>
  </div>
  
  <div id="sidebar">
    <ol class="sidebar-help-panels">
      <li class="panel selected" id="guidelines-sidebar-help">
        <h5>
          <?php __("Eligibility requirements") ?>
        </h5>
        <p>
          <?php __("To be eligible to start a IG9 project, you need to satisfy the requirements of Amazon Payments:") ?>
        </p>
        <ul>
          <li><?php __("You are 18 years of age or older.") ?>          
          <li><?php __("You have a US address, US bank account, and US state-issued ID (driver’s license).") ?>
          </li>
          
        </ul>
      </li>
    </ol>
  </div>
  
</div>