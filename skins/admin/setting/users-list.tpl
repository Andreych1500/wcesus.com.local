<?php if(isset($_REQUEST['add'])){ ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Створити елемент']?></p>
      <a class="back-url" href="/admin/setting/users-list/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab"><?=$messG['Настройки']?></li>
    </ul>

    <form class="content-form" action="" method="post" enctype="multipart/form-data">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="header-line"><?=$mess['Доступ']?></div>

        <div class="input-value">
          <?php foreach($messG['access'] as $k => $v){ ?>
            <label><span><?=$v?>:</span>
              <input type="radio" <?=((isset($error) && (isset($_POST['access']) && $_POST['access'] == $k))? "checked" : (($k == 1)? "checked" : ""))?> name="access" value="<?=$k?>">
            </label>
          <?php } ?>
        </div>

        <div class="header-line"><?=$mess['Персональна інформація']?></div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Активність']?>:</div>
          <input type="checkbox" <?=((isset($error, $_POST['active']))? "checked" : "")?> name="active" value="1">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$messG['Сортування']?>:</div>
          <input type="number" name="sort" value="<?=(isset($error)? (int)$_POST['sort'] : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Ім\'я']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['name'])? $check['name'] : '')?> type="text" name="name" value="<?=(isset($error)? hsc($_POST['name']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Прізвище']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['last_name'])? $check['last_name'] : '')?> type="text" name="last_name" value="<?=(isset($error)? hsc($_POST['last_name']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Побатькові']?>:</div>
          <input type="text" name="end_name" value="<?=(isset($error)? hsc($_POST['end_name']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Логін']?>:<span class="accent">*</span>
            <div class="pop-window"><?=$mess['Кількість символів 6_user']?></div>
          </div>
          <input <?=(isset($check['login'])? $check['login'] : '')?> type="text" name="login" value="<?=(isset($error)? hsc($_POST['login']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section">Email:<span class="accent">*</span></div>
          <input <?=(isset($check['email'])? $check['email'] : '')?> type="text" name="email" value="<?=(isset($error)? hsc($_POST['email']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Пароль']?>:<span class="accent">*</span>
            <div class="pop-window"><?=$mess['Кількість символів 6_user']?></div>
          </div>
          <input <?=(isset($check['pass'])? $check['pass'] : '')?> type="text" name="pass" value="">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Підтвердження пароля']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['check_pass'])? $check['check_pass'] : '')?> type="password" name="check_pass" value="">
        </div>

        <div class="header-line"><?=$mess['Додаткова інформація']?></div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Повідомити листом']?>:</div>
          <input type="checkbox" <?=((isset($error, $_POST['male']))? "checked" : "")?> name="male" value="ok">

          <select name="code_mails">
            <?php  while($arResult = $list->fetch_assoc()){ ?>
              <option value="<?=$arResult['symbol_code']?>" <?=(((isset($error) && $_POST['code_mails'] == $arResult['symbol_code']) || !isset($error) && $k == 0)? 'selected' : "")?>>
                <?=$arResult['symbol_code']?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value upload_file" id="user_avatar" data-priority-type="img">
          <div class="name-section"><?=$mess['Аватар користувача']?>:</div>
          <?php $file = (isset($error) && !empty($_POST['user_avatar'])? hsc($_POST['user_avatar']) : '');
          $exist_file = fileExist($file);
          $size = (!empty($exist_file)? getimagesize($_SERVER['DOCUMENT_ROOT'].$file)[0] : 'auto'); ?>
          <button type="button" onclick="getIdElement(this)">
            <span class="icon-link"></span><?=(!empty($exist_file)? $file : $messG['Вибрати файл'])?>
          </button>
          <input name="user_avatar" type="hidden" value="<?=(!empty($exist_file)? $file : '')?>">
          <input name="del[user_avatar]" type="hidden" value="<?=(isset($_POST['del']['user_avatar'])? hsc($_POST['del']['user_avatar']) : '')?>">
          <div class="photos <?=(!empty($exist_file)? '' : 'hidden')?>">
            <span class="icon-cross removeFile" onclick="removeImage(this)"></span>
            <img src="<?=$exist_file?>" width="<?=$size?>">
          </div>
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Вік']?>:</div>
          <input type="number" name="age" value="<?=(isset($error)? (int)$_POST['age'] : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Телефон']?>:</div>
          <input type="text" name="phone" value="<?=(isset($error)? hsc($_POST['phone']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Професія']?>:</div>
          <input type="text" name="profession" value="<?=(isset($error)? hsc($_POST['profession']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section">Web-site:</div>
          <input type="text" name="web_site" value="<?=(isset($error)? hsc($_POST['web_site']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Стать']?>:</div>
          <select name="floor">
            <?php foreach($messG['floor'] as $k => $v){ ?>
              <option value="<?=$k;?>" <?=(((isset($error) && $_POST['floor'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
                <?=$v;?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Країна']?>:</div>
          <input type="text" name="country" value="<?=(isset($error)? hsc($_POST['country']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Область']?>:</div>
          <input type="text" name="region" value="<?=(isset($error)? hsc($_POST['region']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Місто']?>:</div>
          <input type="text" name="city" value="<?=(isset($error)? hsc($_POST['city']) : "")?>">
        </div>

      </div>

      <input type="submit" value="<?=$messG['Створити']?>" name="ok">
    </form>

    <form action="" id="to_file" enctype="multipart/form-data">
      <input id="control" type="file" name="file" onchange="addFile(this)" data-input="" data-name-submit="<?=$messG['Вибрати файл']?>">
    </form>
  </div>
<?php } elseif(isset($_REQUEST['edit'])) { ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Редагування елемента']?></p>
      <a class="back-url" href="/admin/setting/users-list/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab"><?=$messG['Настройки']?></li>
    </ul>

    <form class="content-form" action="" method="post" enctype="multipart/form-data">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="header-line"><?=$mess['Доступ']?></div>

        <div class="input-value">
          <?php foreach($messG['access'] as $k => $v){ ?>
            <label><span><?=$v?>:</span>
              <input type="radio" <?=((isset($error) && (isset($_POST['access']) && $_POST['access'] == $k))? "checked" : ($arResult['access'] == $k)? "checked" : '')?> name="access" value="<?=$k?>">
            </label>
          <?php } ?>
        </div>

        <div class="header-line"><?=$mess['Персональна інформація']?>:</div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Активність']?>:</div>
          <input type="checkbox" <?=((isset($error, $_POST['active']) || ($arResult['active'] == 1 && !isset($error)))? "checked" : "")?> name="active" value="1">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$messG['Сортування']?>:</div>
          <input type="number" name="sort" value="<?=(isset($error)? (int)$_POST['sort'] : $arResult['sort'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Ім\'я']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['name'])? $check['name'] : '')?> type="text" name="name" value="<?=(isset($error)? hsc($_POST['name']) : $arResult['name'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Прізвище']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['last_name'])? $check['last_name'] : '')?> type="text" name="last_name" value="<?=(isset($error)? hsc($_POST['last_name']) : $arResult['last_name'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Побатькові']?>:</div>
          <input type="text" name="end_name" value="<?=(isset($error)? hsc($_POST['end_name']) : $arResult['end_name'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Логін']?>:<span class="accent">*</span>
            <div class="pop-window"><?=$mess['Кількість символів 6_user']?></div>
          </div>
          <input <?=(isset($check['login'])? $check['login'] : '')?> type="text" name="login" value="<?=(isset($error)? hsc($_POST['login']) : $arResult['login'])?>">
        </div>

        <div class="input-value">
          <div class="name-section">Email:<span class="accent">*</span></div>
          <input <?=(isset($check['email'])? $check['email'] : '')?> type="text" name="email" value="<?=(isset($error)? hsc($_POST['email']) : $arResult['email'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Новий пароль']?>:
            <div class="pop-window"><?=$mess['Кількість символів 6_user']?></div>
          </div>
          <input <?=(isset($check['new_pass'])? $check['new_pass'] : '')?> type="text" name="new_pass" value="">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Підтвердження пароля']?>:</div>
          <input <?=(isset($check['check_pass'])? $check['check_pass'] : '')?> type="password" name="check_pass" value="">
        </div>

        <div class="header-line"><?=$mess['Додаткова інформація']?></div>

        <div class="input-value upload_file" id="user_avatar" data-priority-type="img">
          <div class="name-section"><?=$mess['Аватар користувача']?>:</div>
          <?php $file = (isset($error) && !empty($_POST['user_avatar'])? hsc($_POST['user_avatar']) : $arResult['user_avatar']);
          $exist_file = fileExist($file);
          $size = (!empty($exist_file)? getimagesize($_SERVER['DOCUMENT_ROOT'].$file)[0] : 'auto');
          ?>
          <button type="button" onclick="getIdElement(this)">
            <span class="icon-link"></span><?=(!empty($exist_file)? $file : $messG['Вибрати файл'])?>
          </button>
          <input name="user_avatar" type="hidden" value="<?=(!empty($exist_file)? $file : '')?>">
          <input name="del[user_avatar]" type="hidden" value="<?=(isset($_POST['del']['user_avatar'])? hsc($_POST['del']['user_avatar']) : $arResult['user_avatar'])?>">
          <div class="photos <?=(!empty($exist_file)? '' : 'hidden')?>">
            <span class="icon-cross removeFile" onclick="removeImage(this)"></span>
            <img src="<?=$exist_file?>" width="<?=$size?>">
          </div>
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Вік']?>:</div>
          <input type="number" name="age" value="<?=(isset($error)? (int)$_POST['age'] : $arResult['age'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Телефон']?>:</div>
          <input type="text" name="phone" value="<?=(isset($error)? hsc($_POST['phone']) : $arResult['phone'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Професія']?>:</div>
          <input type="text" name="profession" value="<?=(isset($error)? hsc($_POST['profession']) : $arResult['profession'])?>">
        </div>

        <div class="input-value">
          <div class="name-section">Web-site:</div>
          <input type="text" name="web_site" value="<?=(isset($error)? hsc($_POST['web_site']) : $arResult['web_site'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Стать']?>:</div>
          <select name="floor">
            <?php foreach($messG['floor'] as $k => $v){ ?>
              <option value="<?=$k;?>" <?=(((isset($error) && $_POST['floor'] == $k) || !isset($error) && $arResult['floor'] == $k)? 'selected' : "")?>>
                <?=$v;?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Країна']?>:</div>
          <input type="text" name="country" value="<?=(isset($error)? hsc($_POST['country']) : $arResult['country'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Область']?>:</div>
          <input type="text" name="region" value="<?=(isset($error)? hsc($_POST['region']) : $arResult['region'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Місто']?>:</div>
          <input type="text" name="city" value="<?=(isset($error)? hsc($_POST['city']) : $arResult['city'])?>">
        </div>
      </div>

      <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
    </form>

    <form action="" id="to_file" enctype="multipart/form-data">
      <input id="control" type="file" name="file" onchange="addFile(this)" data-input="" data-name-submit="<?=$messG['Вибрати файл']?>">
    </form>
  </div>
<?php } else { ?>
  <div class="filter">
    <div class="filter-name"><?=$messG['Фільтр']?></div>
    <form action="" method="get">
      <div class="add-field-filter icon-plus"></div>
      <div class="filter-option-list">
        <?php foreach($users_list['setting_column'] as $k => $value){
          if($value['view_filter']){
            echo '<div class="'.(isset($_COOKIE['filter']) && in_array($value['index'], (array)json_decode($_COOKIE['filter']))? 'act-option' : '').'" data-index="'.(int)$value['index'].'">'.$value['name'].'</div>';
          }
        } ?>
      </div>
      <?=$users_list['html_filter']?>
      <input type="submit" name="filter" value="<?=$messG['Пошук']?>">
      <a href="/admin/setting/users-list/?filterReset=ok"><?=$messG['Відмінити']?></a>
    </form>
  </div>

  <div class="section-interface-k1">
    <div class="line-custom">
      <p class="header-name"><?=$mess['Список користувачів']?></p>
    </div>

    <form action="" method="post" onsubmit="return okFrom();">
      <div class="line-custom-next">
        <a href="/admin/setting/users-list/?add=ok" class="add-el icon-plus"><?=$messG['Створити елемент']?></a>
        <input type="submit" value="<?=$messG['Активувати']?>" name="activate" class="option-el">
        <input type="submit" value="<?=$messG['Деактивувати']?>" name="deactivate" class="option-el">
        <input type="submit" value="<?=$messG['Видалити']?>" name="delete" class="option-el">
        <div class="dynamicEdit" data-submit-lang="<?=$messG['Зберегти'].'|'.$messG['Відмінити']?>"></div>
      </div>

      <table class="illustration-table">
        <tr>
          <td><input type="checkbox" name="all_cheked"></td>
          <td></td>
          <?php foreach($users_list['column_list'] as $k => $v){
            if($users_list['setting_column'][$v]['view_table']){ ?>
              <td><?=$users_list['setting_column'][$v]['name']?></td>
            <?php }
          } ?>
        </tr>

        <?php if($users_list['result_DB']->num_rows > 0){
          while($arResult = hsc($users_list['result_DB']->fetch_assoc())){ ?>
            <tr data-id="<?=$arResult['id']?>">
              <td><input type="checkbox" name="ids[]" value="<?=$arResult['id']?>"></td>
              <td class="relative">
                <span class="icon-mob-menu" onclick="openMenuUpdate(this);"></span>
                <div class="menu-update">
                  <a href="/admin/setting/users-list/?edit=<?=$arResult['id']?>"><?=$messG['Редагувати']?></a>
                  <a href="/admin/setting/users-list/?delete=<?=$arResult['id']?>"><?=$messG['Видалити']?></a>
                </div>
              </td>
              <?php foreach($arResult as $k => $value){
                if($users_list['setting_column'][$k]['view_table']){ ?>
                  <td <?=(($users_list['setting_column'][$k]['edit_window'] == 1)? 'data-field="'.$k.'"' : '')?>><?=(($users_list['setting_column'][$k]['field'] == 'tinyint')? $messG[$k][$value] : $value)?></td>
                <?php }
              } ?>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td>-</td>
            <td>-</td>
            <?php foreach($users_list['setting_column'] as $k => $v){
              if($v['view_table']){ ?>
                <td>-</td>
              <?php }
            } ?>
          </tr>
        <?php } ?>
      </table>
    </form>

    <div class="bottom-table">
      <?=$users_list['count_el_page']?>
      <?=$users_list['pagination']?>
    </div>
  </div>
<?php } ?>