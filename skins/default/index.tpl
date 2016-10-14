<!DOCTYPE html>
<html lang="<?=(($lang == Core::$SITE_LANG[0])? Core::$SITE_LANG[0] : $lang)?>" <?=(isset($contentOG)? 'prefix="og: http://ogp.me/ns#"' : "")?> xmlns="http://www.w3.org/1999/html">
<head>
  <meta charset="UTF-8">
  <title><?=Core::$META['title']?></title>
  <meta name="apple-mobile-web-app-title" content="<?=Core::$META['title']?>">
  <meta name="description" content="<?=Core::$META['description']?>">
  <meta name="keywords" content="<?=Core::$META['keywords']?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Савіцький Андрій">
  <meta name="robots" content="index, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="format-detection" content="address=no">

  <?php foreach(Core::$META['dns-prefetch'] as $v){ ?>
    <link rel="dns-prefetch" href="<?=$v?>">
  <?php } ?>
  <link rel="canonical" href="<?=Core::$META['canonical']?>">

  <link rel="alternate" href="<?=Core::$META['alternate']?>" hreflang="x-default">

  <?=(isset($contentOG)? $contentOG : "")?>

  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" href="/touch-icon-iphone.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/touch-icon-ipad.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/touch-icon-iphone-retina.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/touch-icon-ipad-retina.png">

  <style><?=$style?></style>
  <!--[if lt IE 9]>
  <script src="/skins/default/js/ielt9.min.js" defer></script><![endif]-->

  <script src="/vendor/public/jquery/dist/jquery.min.js" defer></script>
  <script src="/vendor/public/jquery.cookie/jquery.cookie.min.js" defer></script>
  <?=(count(Core::$JS)? implode("\n", Core::$JS) : '')?>
  <script src="/skins/default/js/script.min.js?v=<?=$vF?>" defer></script>
</head>

<body itemscope itemtype="http://schema.org/WebPage">
<meta itemprop="description" content="<?=Core::$META['description']?>">

<header itemscope itemtype="http://schema.org/WPHeader">
  <div class="top-panel">
    <address>
      <?php if(isset($_SESSION['dataCard'])){ ?>
        <a class="cab-link" href="/cab/?exit=ok" title="Exit profile" rel="nofollow">Sign out</a>
      <?php } ?>
      <a class="icon-user" href="/cab/" title="Profile" rel="nofollow"></a>
      <a href="<?=(isMobile()? 'tel:' : 'callto:').calltoPhone('2102152724')?>" title="text"><i class="icon-phone"></i>+1-210-215-2724</a>
      <a href="mailto:info@wcesus.com" title="text"><i class="icon-mail"></i>info@wcesus.com</a>
    </address>
  </div>
  <div class="top-menu">
    <div class="scrolling">
      <a class="logo" href="/"> <img src="/skins/default/img/logo.png" alt="logo" title="logo"></a>
      <nav itemscope="" itemtype="http://www.schema.org/SiteNavigationElement">
        <ul>
          <li class="item-top no-sub">
            <a href="/" itemprop="url"><span itemprop="name">Home</span></a>
          </li>

          <li class="item-top">
            <a href="/for-students/" itemprop="url"> Students
              <meta itemprop="name" content="Students">
            </a>

            <ul class="sub-menu">
              <li><a href="/apply/" rel="nofollow">Apply</a></li>
              <li>
                <a href="/for-students/required-documents/" itemprop="url"> Required Documents
                  <meta itemprop="name" content="Students Required Documents">
                </a>
              </li>
              <li>
                <a href="/for-students/fees/" itemprop="url"> Fees
                  <meta itemprop="name" content="Students Fees">
                </a>
              </li>
              <li>
                <a href="/for-students/faq/" itemprop="url"> FAQ
                  <meta itemprop="name" content="Students FAQ">
                </a>
              </li>
            </ul>
          </li>

          <li class="item-top">
            <a href="/job-seekers/" itemprop="url"> Job Seekers
              <meta itemprop="name" content="Job Seekers">
            </a>

            <ul class="sub-menu">
              <li><a href="/apply/" rel="nofollow">Apply</a></li>
              <li>
                <a href="/job-seekers/required-documents/" itemprop="url"> Required Documents
                  <meta itemprop="name" content="Job Seekers Required Documents">
                </a>
              </li>
              <li>
                <a href="/job-seekers/fees/" itemprop="url"> Fees
                  <meta itemprop="name" content="Job Seekers Fees">
                </a>
              </li>
              <li>
                <a href="/job-seekers/faq/" itemprop="url"> FAQ
                  <meta itemprop="name" content="Job Seekers FAQ">
                </a>
              </li>
            </ul>
          </li>

          <li class="item-top">
            <a href="/immigrants/" itemprop="url"> Immigrants
              <meta itemprop="name" content="Immigrants">
            </a>

            <ul class="sub-menu">
              <li><a href="/apply/" rel="nofollow">Apply</a></li>
              <li>
                <a href="/immigrants/required-documents/" itemprop="url"> Required Documents
                  <meta itemprop="name" content="Immigrants Required Documents">
                </a>
              </li>
              <li>
                <a href="/immigrants/fees/" itemprop="url"> Fees
                  <meta itemprop="name" content="Immigrants Fees">
                </a>
              </li>
              <li>
                <a href="/immigrants/faq/" itemprop="url"> FAQ
                  <meta itemprop="name" content="Immigrants FAQ">
                </a>
              </li>
            </ul>
          </li>

          <li class="item-top no-sub">
            <a href="/static/about-us/" itemprop="url"><span itemprop="name">About Us</span></a>
          </li>
        </ul>
      </nav>
      <div id="wsnavtoggle"><span></span></div>
    </div>
  </div>
  <div id="scroll-top"><span>&rsaquo;</span></div>
</header>

<main><?=$content?></main>

<footer itemscope itemtype="http://schema.org/WPFooter">
  <div class="footer-top">
    <div class="section-first-block">
      <div class="fs-big-link">Contact Us<span class="icon-mortar-board"></span></div>
      <address>
        <a href="<?=(isMobile()? 'tel:' : 'callto:').calltoPhone('2102152724')?>" title="#"><span class="icon-phone"></span>+1(210)215-2724</a>
        <a href="mailto:info@wcesus.com" title="info@wcesus.com"><span class="icon-mail"></span>info@wcesus.com</a>
        <p><span class="icon-home"></span>4535 Schertz Rd, Suite 406, San Antonio, TX, 78233, USA</p>
      </address>
      <div class="bottom-info-link">
        <a href="/static/terms-conditions/" title="Terms & Conditions">Terms & Conditions</a>
        <a href="/static/privacy-policy/" title="Privacy Policy">Privacy Policy</a>
        <a href="/static/sitemap/" title="Site Map">Site Map</a>
      </div>
    </div>
    <div class="section-second-block">
      <div class="fs-big-link">About Us<span class="icon-clock"></span></div>
      <div class="fs-text">
        <p>World Class Evaluation Services, LLC is the significant service provider dedicated to providing evaluation services for people across the globe to achieve personal educational and professional goals.</p>
      </div>
      <div class="fs-text">
        <p>In association with global partners, WCES establish and pursue goals to convey skills and knowledge by evaluating for the recognition of international education.</p>
      </div>
      <a class="more-about" href="/static/about-us/" title="About Us">More...</a>
    </div>
    <div class="section-last-block">
      <a class="fs-big-link" href="/apply/" title="Apply card to user">APPLY<span class="icon-pencil"></span></a>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="content">wcesus &copy;<?=Core::$DATA?>. All Rights Reserved</div>
  </div>
</footer>

<?php if(isset($info)){ ?>
  <div class="modalWindow">
    <div class="modal-content">
      <span class="<?=(($info['type'] == 'good'? 'icon-like like' : 'icon-error'))?>"></span> <i>Important Message</i>
      <?=$info['text']?>
      <div class="close">Close</div>
    </div>
  </div>
<?php } ?>
</body>
</html>