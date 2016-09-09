<div class="section-interface-k2">
  <div class="line-custom-edit">
    <p class="header-name-edit"><?=$mess['Настройка листів']?></p>
  </div>

  <!-- Menu tabs --->
  <ul class="tabs-panel">
    <li class="active-tab"><?=$messG['Настройки']?></li>
  </ul>

  <form class="content-form" action="" method="post">

    <!-- Element tabs -->
    <div class="tabs active-block-tabs">
      <div class="input-value">
        <div class="name-section"><?=$mess['Телефон у футері листа']?>:<span class="accent">*</span></div>
        <input <?=(isset($check['phone'])? $check['phone'] : '')?> type="text" name="phone" value="<?=(isset($error)? hsc($_POST['phone']) : hsc($arResult['phone']))?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Email футері листа']?>:<span class="accent">*</span></div>
        <input <?=(isset($check['email_footer'])? $check['email_footer'] : '')?> type="text" name="email_footer" value="<?=(isset($error)? hsc($_POST['email_footer']) : hsc($arResult['email_footer']))?>">
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Email для тестових відправок']?>:<span class="accent">*</span></div>
        <input <?=(isset($check['test_email'])? $check['test_email'] : '')?> type="text" name="test_email" value="<?=(isset($error)? hsc($_POST['test_email']) : hsc($arResult['test_email']))?>">
      </div>
    </div>

    <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
  </form>
</div>