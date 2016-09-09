<?php if($globalAccess){ ?>
  <div class="box-info">
    <div class="bi-header"><?=$mess['Про систему']?></div>
    <div class="bi-text">
      <div class="block-first-text"><?=$mess['system_create']?></div>
      <?php if(!empty($arResult['logo_system'])){ ?>
        <div class="block-img">
          <img src="<?=$arResult['logo_system']?>" alt="Розробка Савіцького Андрія" title="Розробка Савіцького Андрія">
        </div>
      <?php } ?>
      <table class="bi-table">
        <tr>
          <td><?=$mess['Версія PHP']?>:</td>
          <td><?=$arResult['version_php']?></td>
        </tr>
        <tr>
          <td><?=$mess['Веб-сервер']?>:</td>
          <td><?=$arResult['web_server']?></td>
        </tr>
        <tr>
          <td><?=$mess['Версія ядра']?>:</td>
          <td><?=$arResult['version_core']?></td>
        </tr>
        <tr>
          <td><?=$mess['Адреса сайта']?>:</td>
          <td><a href="/"><?=$arResult['address_site']?></a></td>
        </tr>
        <tr>
          <td><?=$mess['Сайт розроблений']?>:</td>
          <td><?=$arResult['site_create']?></td>
        </tr>
        <tr>
          <td><?=$mess['Відповідальне лице']?>:</td>
          <td><?=$arResult['responsible_face']?></td>
        </tr>
        <tr>
          <td><?=$mess['Підтримка SЕО']?>:</td>
          <td><?=$messG['logicYesNo'][$arResult['support_seo']]?></td>
        </tr>
        <tr>
          <td><?=$mess['Підтримка сайту']?>:</td>
          <td><?=$messG['logicYesNo'][$arResult['support_site']]?></td>
        </tr>
        <tr>
          <td><?=$mess['Щомісячна плата']?>:</td>
          <td><?=$arResult['monthly_fee']?></td>
        </tr>
        <tr>
          <td><?=$mess['Телефон']?>:</td>
          <td><a href="<?=(isMobile()? 'tel' : 'callto')?>:38-097-996-73-12"><?=$arResult['phone']?></a></td>
        </tr>
        <tr>
          <td><?=$mess['Email']?>:</td>
          <td><a href="mailto:<?=$arResult['email']?>"><?=$arResult['email']?></a></td>
        </tr>
      </table>
    </div>
  </div>
  <?php if($arResult['active_block_site']){ ?>
    <div class="box-info">
      <div class="bi-header"><?=$mess['Про сайт']?></div>
      <div class="bi-text">
        <table class="bi-table">
          <tr>
            <td><?=$mess['Логотип']?>:</td>
            <td class="reset-td1">
              <?php if(!empty($arResult['brandPhoto'])){ ?>
                <img src="<?=$arResult['brandPhoto']?>" alt="<?=$arResult['brand_site']?>" title="<?=$arResult['brand_site']?>">
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?=$mess['Опис']?>:</td>
            <td><?=$mess['іnfo_description']?></td>
          </tr>
        </table>
      </div>
    </div>
  <?php } ?>
  <div class="box-info">
    <div class="bi-header"><?=$mess['Адміністративна панель']?></div>
    <div class="bi-text">
      <p><?=$mess['admin_panel']?></p>
    </div>
  </div>
<?php } else { ?>
  <form class="auth-block" action="" method="post">
    <div class="style-open-form no-active">
      <div class="style-form-block">
        <div class="auth-name"><?=$mess['Авторизація']?></div>
        <div class="input-name"><?=$mess['Логін']?></div>
        <input required class="<?=(isset($error['notuser'])? $error['notuser'] : "")?>" type="text" name="login" value="<?=(isset($_POST['login'])? hsc($_POST['login']) : '');?>">
        <div class="input-name"><?=$mess['Пароль']?></div>
        <input required class="<?=(isset($error['notuser'])? $error['notuser'] : "")?>" type="password" name="pass" value="<?=(isset($_POST['pass'])? hsc($_POST['pass']) : '');?>">
        <label><input type="checkbox" name="save"><?=$mess['Запам\'ятати мене на цьому комп\'ютері']?></label>
        <input type="submit" name="submit" value="Вхід">
      </div>
    </div>
  </form>
<?php } ?>