<div class="section-interface-k2">
  <div class="line-custom-edit">
    <p class="header-name-edit"><?=$mess['Головний модуль']?></p>
  </div>

  <!-- Menu tabs --->
  <ul class="tabs-panel">
    <li class="active-tab"><?=$messG['Настройки']?></li>
  </ul>

  <form class="content-form" action="" method="post" onsubmit="return okFrom();">

    <!-- Element tabs -->
    <div class="tabs active-block-tabs">
      <div class="input-value">
        <div class="name-section"><?=$mess['Email сайту']?>:<span class="accent">*</span></div>
        <input <?=(isset($check['from_email'])? $check['from_email'] : '')?> type="text" name="from_email" value="<?=(isset($error)? hsc($_POST['from_email']) : hsc($arResult['from_email']))?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Виведення помилок (error_reporting)']?>:</div>
        <select name="error_reporting">
          <?php foreach($messG['error_reporting'] as $k => $v){ ?>
            <option value="<?=$k?>" <?=(((isset($error) && $_POST['error_reporting'] == $k) || ((int)$arResult['error_reporting'] == $k))? 'selected' : "")?>>
              <?=$v?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Дата створення сайту']?>:<span class="accent">*</span></div>
        <input <?=(isset($check['site_data_create'])? $check['site_data_create'] : '')?> type="number" name="site_data_create" value="<?=(isset($error)? hsc($_POST['site_data_create']) : hsc($arResult['site_data_create']))?>" min="2000">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Url сайту без http']?>:<span class="accent">*</span></div>
        <input <?=(isset($check['url_site'])? $check['url_site'] : '')?> type="text" name="url_site" value="<?=(isset($error)? hsc($_POST['url_site']) : hsc($arResult['url_site']))?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Url сайту з http']?>:<span class="accent">*</span></div>
        <input <?=(isset($check['url_http_site'])? $check['url_http_site'] : '')?> type="text" name="url_http_site" value="<?=(isset($error)? hsc($_POST['url_http_site']) : hsc($arResult['url_http_site']))?>">
      </div>

      <div class="technik-off-onn">
        <?=$mess['Тимчасове закриття публічної частини сайту']?>:
        <div class="procedure-section">
          <?php if($arResult['access_publick_page']){ ?>
            <p class="color-green"><?=$mess['Доступ відкритий']?></p>
            <a href="/admin/setting/main-module/?access_publick_page=0"><?=$mess['Закрити доступ']?></a>
          <?php } else { ?>
            <p class="color-red"><?=$mess['Доступ закритий']?></p>
            <a href="/admin/setting/main-module/?access_publick_page=1"><?=$mess['Відкрити доступ']?></a>
          <?php } ?>
        </div>
      </div>
    </div>

    <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
  </form>
</div>