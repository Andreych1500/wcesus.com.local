<div class="section-interface-k2">
  <div class="line-custom-edit">
    <p class="header-name-edit"><?=$mess['Переклад сайту']?></p>
  </div>

  <!-- Menu tabs --->
  <ul class="tabs-panel">
    <li class="active-tab"><?=$messG['Настройки']?></li>
  </ul>

  <form class="content-form" action="" method="post">

    <!-- Element tabs -->
    <div class="tabs active-block-tabs">
      <div class="header-line"><?=$mess['Настройки пошуку']?>:</div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Місце пошуку']?>:</div>
        <select name="template">
          <option value="site" <?=((isset($_POST['template']) && $_POST['template'] == 'site')? 'selected' : '')?>>Site</option>
          <option value="admin" <?=((isset($_POST['template']) && $_POST['template'] == 'admin')? 'selected' : '')?>>Admin</option>
        </select>
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Мова пошуку']?>:</div>
        <select name="lang">
          <?php foreach(Core::$ADMIN_LANG as $value){ ?>
            <option value="<?=$value?>" <?=((isset($_POST['lang']) && $_POST['lang'] == $value)? 'selected' : '')?>><?=$value?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <?php if(isset($words) && count($words) > 0){ ?>
      <div class="technik-off-onn">
        <?=$mess['Неперекладені слова']?>:
        <?php foreach($words as $section => $v){ ?>
          <div class="header-line"><?=$section?></div><code class="word-lang-code"><?=wtf($v, 1)?></code>
        <?php } ?>
      </div>
    <?php } ?>

    <input type="submit" value="<?=$messG['Пошук']?>" name="ok">
  </form>
</div>