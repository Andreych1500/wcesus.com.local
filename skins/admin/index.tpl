<!DOCTYPE html>
<html class="<?=(($globalAccess)? "admin-panel" : "auth-panel")?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?=$messG['Адміністративна панель title']?></title>

  <meta name="robots" content="index, nofollow">
  <meta name="author" content="Савіцький Андрій">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no">
  <meta name="format-detection" content="address=no">

  <link rel="dns-prefetch" href="http://childrensdream.com.ua">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" href="/touch-icon-iphone.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/touch-icon-ipad.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/touch-icon-iphone-retina.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/touch-icon-ipad-retina.png">

  <link rel="stylesheet" href="/skins/admin/css/reset.min.css?v=<?=$vF?>">
  <link rel="stylesheet" href="/skins/admin/css/style.min.css?v=<?=$vF?>">

  <script src="/vendor/public/jquery/dist/jquery.min.js" defer></script>
  <script src="/vendor/public/jquery.cookie/jquery.cookie.min.js" defer></script>
  <script src="/vendor/public/translit/dist/translit.js" defer></script>
  <script src="/skins/admin/js/script-menu.min.js?v=<?=$vF?>" defer></script>
  <script src="/skins/admin/js/script-click-menu.js?v=<?=$vF?>" defer></script>
</head>

<body>
<?php if($globalAccess){ ?>

  <header>
    <div class="container">
      <div class="nth1-panel">
        <a href="/admin/setting/users-list/?edit=<?=$_SESSION['user']['id']?>" class="to-cab icon-user-tie"><?=$_SESSION['user']['last_name'].' '.$_SESSION['user']['name']?></a>
        <a href="/admin/?exit=ok"><?=$messG['Вихід']?></a>
        <div class="lang-info"><?=$lang?></div>
      </div>
      <div class="nth2-panel">
        <a class="to-site" target="_blank" href="//<?=$_SERVER['HTTP_HOST']?>"><?=$messG['Сайт']?></a>
        <a class="to-admin" href="//<?=$_SERVER['HTTP_HOST']?>/admin"><?=$messG['Адміністрування']?></a>
      </div>
      <div class="lang-open-click">
        <div class="adm-informer-header"><?=$messG['Вибір мови']?></div>
        <?php foreach(Core::$ADMIN_LANG as $value){
          if($value != $_COOKIE['lang_admin']){
            echo '<div class="informer-item"><a href="/'.$_REQUEST['route'].'?lang_admin='.$value.'">'.$value.'</a></div>';
          }
        } ?>
      </div>
    </div>
    <div class="adm-header-bottom"></div>
  </header>

  <main class="pc-version">
    <aside>
      <ul class="navigation">
        <?php foreach($admin_menu[$lang] as $k => $arResult){ ?>
          <li <?=((isset($_COOKIE['act-menu']) && $_COOKIE['act-menu'] == $k)? 'class="act-navigation"' : '')?>>
            <p><span class="icon-<?=$arResult['icon']?>"></span><?=$arResult['name']?></p>
            <span class="animate-hover"></span>
          </li>
        <?php } ?>
      </ul>
    </aside>
    <div class="navigation-lv2 <?=(isset($_COOKIE['act-menu'])? 'act-nav-lv2' : '')?>">
      <?php foreach($admin_menu[$lang] as $k => $arResult){ ?>
        <ul class="section-lv2 <?=((isset($_COOKIE['act-menu']) && $_COOKIE['act-menu'] == $k)? 'act-section' : '')?>">
          &nbsp;<?=$arResult['name']?>
          <?php
          $j = 0;
          foreach($arResult['sections'] as $nameSection => $arSections){ ?>
            <li class="list-sec-menu <?=(isset($arrayActMenu)? (in_array($k.':'.$j, $arrayActMenu)? 'act-list' : '') : '')?>">
              <span class="icon-left"></span><?=$nameSection?>
              <ul class="section-module">
                <?php foreach($arSections as $name => $link){ ?>
                  <li><a href="<?=$link?>"><?=$name?></a></li>
                <?php } ?>
              </ul>
            </li>
            <?php ++$j;
          } ?>
        </ul>
      <?php } ?>
    </div>

    <!-- Content --->
    <div class="content">
      <?php if(isset($info)){ // Info window ?>
        <div class="adm-info-block <?=$info['type']?>">
          <div class="adm-info-text">
            <span class="icon-<?=$info['icon']?>"></span>
            <?=$info['text']?>
          </div>
        </div>
      <?php } ?>
      <?=$content?>
    </div>
  </main>

  <footer>
    <div class="adm-header-bottom"></div>
    <div class="container"><?=$messG['Адміністративна панель']?>.<br><?=$messG['Усі права захищені']?> &copy; <?=data(Core::$DATA)?>.
    </div>
  </footer>

<?php } else { ?>

  <header>
    <div class="topPanel no-active">
      <a href="//<?=$_SERVER['HTTP_HOST']?>"><span class="icon-circle-left"></span>www.<?=$_SERVER['HTTP_HOST']?></a>
      <div class="lang-info"><?=$lang?></div>
      <div class="lang-open-click">
        <div class="adm-informer-header"><?=$messG['Вибір мови']?></div>
        <?php foreach(Core::$ADMIN_LANG as $value){ ?>
          <div class="informer-item">
            <?php if($value != $_COOKIE['lang_admin']){
              echo '<a href="/'.$_REQUEST['route'].'?lang_admin='.$value.'">'.$value.'</a>';
            } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </header>

  <main class="auth-main"><?=$content?></main>

  <footer>
    <div class="bottom-panel no-active"><?=$messG['Адміністративна панель']?>.<br><?=$messG['Усі права захищені']?> &copy; <?=data(Core::$DATA)?>.
    </div>
  </footer>

<?php } ?>
</body>
</html>