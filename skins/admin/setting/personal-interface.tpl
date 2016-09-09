<div class="section-interface-k2">
  <div class="line-custom-edit">
    <p class="header-name-edit"><?=$mess['Персональні настройки адміністрування']?></p>
  </div>

  <!-- Menu tabs --->
  <ul class="tabs-panel">
    <li class="active-tab"><?=$messG['Настройки']?></li>
  </ul>

  <form class="content-form" action="" method="post" enctype="multipart/form-data">

    <!-- Element tabs -->
    <div class="tabs active-block-tabs">
      <div class="header-line"><?=$mess['Про систему']?></div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Версія PHP']?>:</div>
        <input type="text" name="version_php" value="<?=(isset($error)? hsc($_POST['version_php']) : $arResult['version_php'])?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Веб-сервер']?>:</div>
        <input type="text" name="web_server" value="<?=(isset($error)? hsc($_POST['web_server']) : $arResult['web_server'])?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Версія ядра']?>:</div>
        <input type="text" name="version_core" value="<?=(isset($error)? hsc($_POST['version_core']) : $arResult['version_core'])?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Адреса сайта']?>:</div>
        <input type="text" name="address_site" value="<?=(isset($error)? hsc($_POST['address_site']) : $arResult['address_site'])?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Сайт розроблений']?>:</div>
        <input type="text" name="site_create" value="<?=(isset($error)? hsc($_POST['site_create']) : $arResult['site_create'])?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Відповідальне лице']?>:</div>
        <input type="text" name="responsible_face" value="<?=(isset($error)? hsc($_POST['responsible_face']) : $arResult['responsible_face'])?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Підтримка SЕО']?>:</div>
        <select name="support_seo">
          <?php foreach($messG['logicYesNo'] as $k => $v){ ?>
            <option value="<?=$k?>" <?=(((isset($error) && $_POST['support_seo'] == $k) || ((int)$arResult['support_seo'] == $k))? 'selected' : "")?>>
              <?=$v?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Підтримка сайту']?>:</div>
        <select name="support_site">
          <?php foreach($messG['logicYesNo'] as $k => $v){ ?>
            <option value="<?=$k?>" <?=((isset($error) && $_POST['support_site'] == $k) || ((int)$arResult['support_site'] == $k)? 'selected' : "")?>>
              <?=$v?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Щомісячна плата']?>:</div>
        <input type="text" name="monthly_fee" value="<?=(isset($error)? hsc($_POST['monthly_fee']) : $arResult['monthly_fee'])?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Телефон']?>:</div>
        <input type="text" name="phone" value="<?=(isset($error)? hsc($_POST['phone']) : $arResult['phone'])?>">
      </div>

      <div class="input-value">
        <div class="name-section">Email:</div>
        <input type="text" name="email" value="<?=(isset($error)? hsc($_POST['email']) : $arResult['email'])?>">
      </div>

      <div class="header-line"><?=$mess['Адміністративна панель']?></div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Блок сайту']?>:</div>
        <input type="checkbox" <?=((isset($error, $_POST['active_block_site']) || ($arResult['active_block_site'] == 1 && !isset($error)))? "checked" : "")?> name="active_block_site" value="1">
      </div>

      <div class="input-value upload_file" id="logo_system" data-priority-type="img">
        <div class="name-section"><?=$mess['Логотип \'MVC\'']?>:</div>
        <?php $file = (isset($error) && !empty($_POST['logo_system'])? hsc($_POST['logo_system']) : $arResult['logo_system']);
        $exist_file = fileExist($file);
        $size = (!empty($exist_file)? getimagesize($_SERVER['DOCUMENT_ROOT'].$file)[0] : 'auto'); ?>
        <button type="button" onclick="getIdElement(this)">
          <span class="icon-link"></span><?=(!empty($exist_file)? $file : $messG['Вибрати файл'])?>
        </button>
        <input name="logo_system" type="hidden" value="<?=(!empty($exist_file)? $file : '')?>">
        <input name="del[logo_system]" type="hidden" value="<?=(isset($_POST['del']['logo_system'])? hsc($_POST['del']['logo_system']) : $arResult['logo_system'])?>">
        <div class="photos <?=(!empty($exist_file)? '' : 'hidden')?>">
          <span class="icon-cross removeFile" onclick="removeImage(this)"></span>
          <img src="<?=$exist_file?>" width="<?=$size?>">
        </div>
      </div>

      <div class="header-line"><?=$mess['Про сайт']?></div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Марка сайту']?>:</div>
        <input type="text" name="brand_site" value="<?=(isset($error)? hsc($_POST['brand_site']) : $arResult['brand_site'])?>">
      </div>

      <div class="input-value upload_file" id="brandPhoto" data-priority-type="img">
        <div class="name-section"><?=$mess['Логотип сайту']?>:</div>
        <?php $file = (isset($error) && !empty($_POST['brandPhoto'])? hsc($_POST['brandPhoto']) : $arResult['brandPhoto']);
        $exist_file = fileExist($file);
        $size = (!empty($exist_file)? getimagesize($_SERVER['DOCUMENT_ROOT'].$file)[0] : 'auto'); ?>
        <button type="button" onclick="getIdElement(this)">
          <span class="icon-link"></span><?=(!empty($exist_file)? $file : $messG['Вибрати файл'])?>
        </button>
        <input name="brandPhoto" type="hidden" value="<?=(!empty($exist_file)? $file : '')?>">
        <input name="del[brandPhoto]" type="hidden" value="<?=(isset($_POST['del']['brandPhoto'])? hsc($_POST['del']['brandPhoto']) : $arResult['brandPhoto'])?>">
        <div class="photos <?=(!empty($exist_file)? '' : 'hidden')?>">
          <span class="icon-cross removeFile" onclick="removeImage(this)"></span>
          <img src="<?=$exist_file?>" width="<?=$size?>">
        </div>
      </div>
    </div>
    <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
  </form>

  <form action="" id="to_file" enctype="multipart/form-data">
    <input id="control" type="file" name="file" onchange="addFile(this)" data-input="" data-name-submit="<?=$messG['Вибрати файл']?>">
  </form>
</div>