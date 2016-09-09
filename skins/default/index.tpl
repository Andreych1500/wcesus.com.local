<!DOCTYPE html>
<html lang="<?=(($lang == Core::$SITE_LANG[0]) ? Core::$SITE_LANG[0] : $lang)?>" <?=(isset($contentOG) ? 'prefix="og: http://ogp.me/ns#"' : "")?>>
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

  <?php foreach (Core::$META['dns-prefetch'] as $v) { ?>
    <link rel="dns-prefetch" href="<?=$v?>">
  <?php } ?>
  <link rel="canonical" href="<?=Core::$META['canonical']?>">

  <link rel="alternate" href="<?=Core::$META['alternate']?>" hreflang="x-default">

  <?=(isset($contentOG) ? $contentOG : "")?>

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
  <?=(count(Core::$JS) ? implode("\n", Core::$JS) : '')?>
  <script src="/skins/default/js/script.min.js?v=<?=$vF?>" defer></script>
</head>

<body itemscope itemtype="http://schema.org/WebPage">
<meta itemprop="description" content="<?=Core::$META['description']?>">
<header itemscope itemtype="http://schema.org/WPHeader"></header>

<main><?=$content?></main>

<footer itemscope itemtype="http://schema.org/WPFooter"></footer>
</body>
</html>