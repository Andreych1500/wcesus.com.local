<!DOCTYPE html>
<html>
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

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/touch-icon-ipad-retina.png">

    <link href="/skins/<?=Core::$SKIN?>/css/style.min.css?v=<?=$vF?>" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/skins/default/js/ielt9.min.js" defer></script><![endif]-->

    <script src="/vendor/public/jquery/dist/jquery.min.js" defer></script>
    <script src="/vendor/public/jquery.cookie/jquery.cookie.min.js" defer></script>
    <script src="/skins/default/js/script.min.js?v=<?=$vF?>" defer></script>
</head>

<body>

<header itemscope itemtype="http://schema.org/WPHeader">
    <div class="top-panel">
        <address>
            <a class="icon-user" href="/cab/" title="Profile" rel="nofollow"></a>
            <a href="<?=(isMobile()? 'tel:' : 'callto:').calltoPhone('2102152724')?>" title="text"><i class="icon-phone"></i>+1-210-215-2724</a>
            <a href="mailto:info@wcesus.com" title="text"><i class="icon-mail"></i>info@wcesus.com</a>
        </address>
    </div>
    <div class="top-menu">
        <div class="scrolling">
            <a class="logo" href="/"> <img src="/skins/default/img/logo.png" alt="logo" title="logo"> </a>
            <nav itemscope="" itemtype="http://www.schema.org/SiteNavigationElement">
                <ul>
                    <li class="item-top">
                        <a <?=(($link_lang == '/')? 'class="active"' : '')?> href="#">Home</a>
                        <ul class="sub-menu">
                            <li><a href="#">Full-Screen Slider</a></li>
                            <li><a href="#">Video Slider</a></li>
                        </ul>
                    </li>

                    <li class="item-top">
                        <a href="#">Features</a>
                        <ul class="sub-menu">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Our Staff</a></li>
                        </ul>
                    </li>

                    <li class="item-mega">
                        <a href="#">Features2</a>
                        <ul class="sub-mega-menu">
                            <li>
                                <div class="header-mega-menu">Pages</div>
                                <ul>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Our Staff</a></li>
                                    <li><a href="#">Services</a></li>
                                    <li><a href="#">Full-Width Page</a></li>
                                    <li><a href="#">Page Left Sidebar</a></li>
                                    <li><a href="#">Page Right Sidebar</a></li>
                                    <li><a href="#">Double Sidebars</a></li>
                                    <li><a href="#">Faq Page</a></li>
                                    <li><a href="#">SiteMap</a></li>
                                    <li><a href="#">404 Page</a></li>
                                </ul>
                            </li>
                            <li>
                                <div class="header-mega-menu">Content</div>
                                <ul>
                                    <li><a href="#">Content Elements</a></li>
                                    <li><a href="#">Typography</a></li>
                                    <li><a href="#">Pricing Plans</a></li>
                                    <li><a href="#">Pricing Plans2</a></li>
                                </ul>
                                <img src="/skins/default/img/250x150-img-2.jpg" alt="">
                            </li>
                            <li>
                                <div class="header-mega-menu">Portfolio</div>
                                <ul>
                                    <li><a href="#">One Column</a></li>
                                    <li><a href="#">Two Columns</a></li>
                                    <li><a href="#">Three Columns</a></li>
                                    <li><a href="#">Four Columns</a></li>
                                    <li><a href="#">Gallery</a></li>
                                    <li><a href="#">Filtered</a></li>
                                </ul>
                                <img src="/skins/default/img/250x150-img-3.jpg" alt="">
                            </li>
                            <li>
                                <div class="header-mega-menu">Blog</div>
                                <ul>
                                    <li id="menu-item-29"><a href="blog-default.html">Default</a></li>
                                    <li id="menu-item-30"><a href="blog-two-columns.html">Two Columns</a></li>
                                    <li id="menu-item-31"><a href="blog-three-columns.html">Three Columns</a></li>
                                    <li id="menu-item-32"><a href="blog-fullwidth.html">Full Width</a></li>
                                    <li id="menu-item-33"><a href="blog-post.html">Blog Post</a></li>
                                </ul>
                                <img src="/skins/default/img/250x150-img-4.jpg" alt="">
                            </li>
                        </ul>
                    </li>

                    <li class="item-top no-sub">
                        <a href="#">Contact-us</a>
                    </li>
                </ul>
            </nav>
            <div id="wsnavtoggle"><span></span></div>
        </div>
    </div>
</header>

<main>
    <div class="i_Error"><?=$status_error?></div>
</main>

<footer itemscope itemtype="http://schema.org/WPFooter">
    <div class="footer-top">
        <div class="section-first-block">
            <div class="fs-big-link">ABOUT US<span class="icon-mortar-board"></span></div>
            <div class="fs-text">
                <b>Sed aliquet dui auctor blandit ipsum tincidunt</b> Quis rhoncus lorem dolor eu sem. Aenean enim risus, convallis id ultrices eget.
            </div>
            <address>
                <a href="<?=(isMobile()? 'tel:' : 'callto:').calltoPhone('2102152724')?>" title="#"><span class="icon-phone"></span>123-123456789</a>
                <a href="mailto:test@test.com" title="#"><span class="icon-mail"></span>test@test.com</a> <p><span class="icon-home"></span>250 Biscayne Blvd. (North) 11st Floor New World Tower Miami, 33148</p>
            </address>
            <div class="soc-link"></div>
        </div>
        <div class="section-second-block">
            <div class="fs-big-link">LATEST COURSES<span class="icon-clock"></span></div>
            <div class="fs-text">
                <b>Sed aliquet dui at auctor blandit</b>
                <div class="course-date">
                    <span>10 <sup>00</sup></span> <span>23.02.15</span>
                </div>
                <p>Sed pharetra lorem ut dolor dignissim, sit amet pretium tortor mattis.</p>
            </div>
            <div class="fs-text">
                <b>Sed aliquet dui at auctor blandit</b>
                <div class="course-date">
                    <span>10 <sup>00</sup></span> <span>23.02.15</span>
                </div>
                <p>Sed pharetra lorem ut dolor dignissim, sit amet pretium tortor mattis.</p>
            </div>
        </div>
        <div class="section-last-block">
            <a class="fs-big-link" href="/apply/" title="Apply card to user">APPLY<span class="icon-pencil"></span></a>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="content">wcesus &copy;<?=Core::$DATA?>. All Rights Reserved</div>
    </div>
</footer>
</body>
</html>