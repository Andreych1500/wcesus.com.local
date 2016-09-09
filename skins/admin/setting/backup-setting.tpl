<?php if(isset($_REQUEST['backup-setting'])){ ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$mess['Редагування Backup']?></p>
      <a class="back-url" href="/admin/setting/backup-setting/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab"><?=$messG['Настройки']?></li>
    </ul>

    <form class="content-form" action="" method="post">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="header-line"><?=$mess['Настройки резервного копіювання']?></div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Назва Data Base']?>:<span class="accent">*</span>
            <div class="pop-window"><?=$mess['Назви баз даних _backup']?></div>
          </div>
          <input type="text" name="name_db" <?=(isset($check['name_db'])? $check['name_db'] : '')?>
            value="<?=(isset($error)? hsc($_POST['name_db']) : hsc($arResult['name_db']))?>">
        </div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Виключення папок']?>:<span class="accent">*</span>
            <div class="pop-window"><?=$mess['Папки та файли _backup']?></div>
          </div>
          <textarea name="unset_dir_to_zip" <?=(isset($check['unset_dir_to_zip'])? $check['unset_dir_to_zip'] : '')?>><?=((isset($error))? hsc($_POST['unset_dir_to_zip']) : hsc($arResult['unset_dir_to_zip']))?></textarea>
        </div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Інтервал видалення']?>:<span class="accent">*</span>
            <div class="pop-window"><?=$mess['Інтервал часу _backup']?></div>
          </div>
          <input type="number" min="1" name="time_delete_zip" <?=(isset($check['time_delete_zip'])? $check['time_delete_zip'] : '')?>
            value="<?=(isset($error)? hsc($_POST['time_delete_zip']) : hsc($arResult['time_delete_zip']))?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Ім\'я префіксу архіва']?>:<span class="accent">*</span></div>
          <input type="text" name="name_prefix_dir_zip" <?=(isset($check['name_prefix_dir_zip'])? $check['name_prefix_dir_zip'] : '')?>
            value="<?=(isset($error)? hsc($_POST['name_prefix_dir_zip']) : hsc($arResult['name_prefix_dir_zip']))?>">
        </div>
      </div>

      <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
    </form>
  </div>
<?php } else { ?>
  <div class="section-interface-k1">
    <div class="line-custom">
      <p class="header-name"><?=$mess['Настройки Backup']?></p>
    </div>

    <table class="illustration-table">
      <tr>
        <td><?=$mess['Backup баз даних']?></td>
        <td><?=$mess['Папки | Файли']?>s</td>
        <td><?=$mess['Час життя Backup-у']?></td>
        <td><?=$mess['Префіксне ім\'я']?></td>
        <td><?=$messG['Час оновлення']?></td>
        <td><?=$messG['Ким оновлений']?></td>
      </tr>
      <tr>
        <td><?=$arResult['name_db']?></td>
        <td><?=$arResult['unset_dir_to_zip']?></td>
        <td><?=$arResult['time_delete_zip']?></td>
        <td><?=$arResult['name_prefix_dir_zip']?></td>
        <td><?=$arResult['date_custom']?></td>
        <td><?=$arResult['user_custom']?></td>
      </tr>
    </table>
    <div class="bottom-table">
      <a class="reload-file" href="/admin/setting/backup-setting/?backup-setting=ok"><?=$mess['Змінити налаштування']?></a>
    </div>
  </div>
<?php } ?>