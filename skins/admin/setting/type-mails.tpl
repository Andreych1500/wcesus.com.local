<?php if(isset($_REQUEST['add'])){ ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Створити елемент']?></p>
      <a class="back-url" href="/admin/setting/type-mails/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab"><?=$messG['Настройки']?></li>
    </ul>

    <form class="content-form" action="" method="post">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="input-value">
          <div class="name-section"><?=$mess['Активність']?>:</div>
          <input type="checkbox" <?=((isset($error, $_POST['active']))? "checked" : "")?> name="active" value="1">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Назва']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['name'])? $check['name'] : '')?> type="text" name="name" value="<?=(isset($error)? hsc($_POST['name']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$messG['Сортування']?>:</div>
          <input type="number" name="sort" value="<?=(isset($error)? (int)$_POST['sort'] : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$messG['Символьний код']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['symbol_code'])? $check['symbol_code'] : '')?> type="text" name="symbol_code" value="<?=(isset($error)? hsc($_POST['symbol_code']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Прихована копія']?>
            <div class="pop-window"><?=$messG['Перечислюємо через кому']?></div>
          </div>
          <input type="text" name="hidden_copy" value="<?=(isset($error)? hsc($_POST['hidden_copy']) : "")?>">
        </div>

        <div class="header-line"><?=$messG['Увага!']?></div>
      </div>

      <input type="submit" value="<?=$messG['Створити']?>" name="ok">
    </form>
  </div>
<?php } elseif(isset($_REQUEST['edit'])) { ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Редагування елемента']?></p>
      <a class="back-url" href="/admin/setting/type-mails/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab"><?=$messG['Настройки']?></li>
    </ul>

    <form class="content-form" action="" method="post">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="input-value">
          <div class="name-section"><?=$mess['Активність']?>:</div>
          <input type="checkbox" <?=((isset($error, $_POST['active']) || ($arResult['active'] == 1 && !isset($error)))? "checked" : "")?> name="active" value="1">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Назва']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['name'])? $check['name'] : '')?> type="text" name="name" value="<?=(isset($error)? hsc($_POST['name']) : hsc($arResult['name']))?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$messG['Сортування']?>:</div>
          <input type="number" name="sort" value="<?=(isset($error)? (int)$_POST['sort'] : $arResult['sort'])?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$messG['Символьний код']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['symbol_code'])? $check['symbol_code'] : '')?> type="text" name="symbol_code" value="<?=(isset($error)? hsc($_POST['symbol_code']) : hsc($arResult['symbol_code']))?>">
        </div>

        <div class="input-value">
          <div class="name-section"><span class="pop-info">i</span><?=$mess['Прихована копія']?>:
            <div class="pop-window"><?=$messG['Видалити пункт']?></div>
          </div>
          <input type="text" name="hidden_copy" value="<?=(isset($error)? hsc($_POST['hidden_copy']) : hsc($arResult['hidden_copy']))?>">
        </div>

        <div class="header-line"><?=$mess['Додаткові налаштування']?></div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Тема листа']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['theme_list'])? $check['theme_list'] : '')?> type="text" name="theme_list" value="<?=(isset($error)? hsc($_POST['theme_list']) : hsc($arResult['theme_list']))?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Заголовок листа']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['header_list'])? $check['header_list'] : '')?> type="text" name="header_list" value="<?=(isset($error)? hsc($_POST['header_list']) : hsc($arResult['header_list']))?>">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$mess['Причина листа']?>:<span class="accent">*</span></div>
          <input <?=(isset($check['why_list'])? $check['why_list'] : '')?> type="text" name="why_list" value="<?=(isset($error)? hsc($_POST['why_list']) : hsc($arResult['why_list']))?>">
        </div>

        <div class="input-value redactor">
          <div class="name-section"><?=$mess['Текст листа']?>:<span class="accent">*</span></div>
          <textarea <?=(isset($check['text'])? $check['text'] : '')?> name="text"><?=((isset($error))? hsc($_POST['text']) : $arResult['text'])?></textarea>
        </div>

      </div>
      <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
    </form>
  </div>
<?php } elseif(isset($_REQUEST['view'])) { ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$mess['Шаблон листа']?></p>
      <a class="back-url" href="/admin/setting/type-mails/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab"><?=$mess['Лист']?></li>
    </ul>

    <form class="content-form" action="" method="post" onsubmit="return okFrom();">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="header-line"><?=$mess['Вигляд листа']?>:</div>
        <div class="html-view-block"><?=preg_replace("#body#uis", 'div', TemplateMail::HtmlMail('', $template['symbol_code'], $arMainParam, 0))?></div>
      </div>


      <div class="technik-off-onn">
        <?=$mess['Тестова відправка листа']?>:
        <div class="procedure-section">
          <p class="st-form"><span><?=$mess['Ким відправляється']?>:</span> <?=$arMainParam['from_email']?></p>
          <p class="st-form"><span><?=$mess['Кому']?>:</span>
            <input <?=(isset($check['test_email'])? $check['test_email'] : '')?> type="email" name="test_email" value="">
          </p>

          <input type="submit" name="send" value="<?=$mess['Відправити тестовий лист']?>">
        </div>
      </div>

      <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
    </form>
  </div>
<?php } else { ?>
  <div class="filter">
    <div class="filter-name"><?=$messG['Фільтр']?></div>
    <form action="" method="get">
      <div class="add-field-filter icon-plus"></div>
      <div class="filter-option-list">
        <?php foreach($type_mails['setting_column'] as $k => $value){
          if($value['view_filter']){
            echo '<div class="'.(isset($_COOKIE['filter']) && in_array($value['index'], (array)json_decode($_COOKIE['filter']))? 'act-option' : '').'" data-index="'.(int)$value['index'].'">'.$value['name'].'</div>';
          }
        } ?>
      </div>
      <?=$type_mails['html_filter']?>
      <input type="submit" name="filter" value="<?=$messG['Пошук']?>">
      <a href="/admin/setting/type-mails/?filterReset=ok"><?=$messG['Відмінити']?></a>
    </form>
  </div>

  <div class="section-interface-k1">
    <div class="line-custom">
      <p class="header-name"><?=$mess['Типи листів']?></p>
    </div>

    <form action="" method="post" onsubmit="return okFrom();">
      <div class="line-custom-next">
        <a href="/admin/setting/type-mails/?add=ok" class="add-el icon-plus"><?=$messG['Створити елемент']?></a>
        <input type="submit" value="<?=$messG['Активувати']?>" name="activate" class="option-el">
        <input type="submit" value="<?=$messG['Деактивувати']?>" name="deactivate" class="option-el">
        <input type="submit" value="<?=$messG['Видалити']?>" name="delete" class="option-el">
        <div class="dynamicEdit" data-submit-lang="<?=$messG['Зберегти'].'|'.$messG['Відмінити']?>"></div>
      </div>

      <table class="illustration-table">
        <tr>
          <td><input type="checkbox" name="all_cheked"></td>
          <td></td>
          <?php foreach($type_mails['column_list'] as $k => $v){
            if($type_mails['setting_column'][$v]['view_table']){ ?>
              <td><?=$type_mails['setting_column'][$v]['name']?></td>
            <?php }
          } ?>
        </tr>

        <?php if($type_mails['result_DB']->num_rows > 0){
          while($arResult = hsc($type_mails['result_DB']->fetch_assoc())){ ?>
            <tr data-id="<?=$arResult['id']?>">
              <td><input type="checkbox" name="ids[]" value="<?=$arResult['id']?>"></td>
              <td class="relative">
                <span class="icon-mob-menu" onclick="openMenuUpdate(this);"></span>
                <div class="menu-update">
                  <a href="/admin/setting/type-mails/?edit=<?=$arResult['id']?>"><?=$messG['Редагувати']?></a>
                  <a href="/admin/setting/type-mails/?view=<?=$arResult['id']?>"><?=$messG['Переглянути']?></a>
                  <a href="/admin/setting/type-mails/?delete=<?=$arResult['id']?>"><?=$messG['Видалити']?></a>
                </div>
              </td>
              <?php foreach($arResult as $k => $value){
                if($type_mails['setting_column'][$k]['view_table']){ ?>
                  <td <?=(($type_mails['setting_column'][$k]['edit_window'] == 1)? 'data-field="'.$k.'"' : '')?>><?=(($type_mails['setting_column'][$k]['field'] == 'tinyint')? $messG[$k][$value] : $value)?></td>
                <?php }
              } ?>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td>-</td>
            <td>-</td>
            <?php foreach($type_mails['setting_column'] as $k => $v){
              if($v['view_table']){ ?>
                <td>-</td>
              <?php }
            } ?>
          </tr>
        <?php } ?>
      </table>
    </form>

    <div class="bottom-table">
      <?=$type_mails['count_el_page']?>
      <?=$type_mails['pagination']?>
    </div>
  </div>
<?php } ?>