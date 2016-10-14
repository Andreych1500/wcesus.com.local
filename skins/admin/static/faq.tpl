<?php if(isset($_REQUEST['add'])){ ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Створити елемент']?></p>
      <a class="back-url" href="/admin/static/faq/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab"><?=$messG['Настройки']?></li>
    </ul>

    <form class="content-form" action="" method="post" enctype="multipart/form-data">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">

        <div class="input-value">
          <div class="name-section">Active:</div>
          <input type="checkbox" <?=((isset($error, $_POST['active']))? "checked" : "")?> name="active" value="1">
        </div>

        <div class="input-value">
          <div class="name-section">Sort:</div>
          <input type="number" name="sort" value="<?=(isset($error)? (int)$_POST['sort'] : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section">Question:<span class="accent">*</span></div>
          <input <?=(isset($check['question'])? $check['question'] : '')?> type="text" name="question" value="<?=(isset($error)? hsc($_POST['question']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section">Type FAQ:<span class="accent">*</span></div>
          <select name="type_faq">
            <?php foreach($messG['type_faq'] as $k => $v){ ?>
              <option value="<?=$k?>" <?=((isset($_POST['type_faq']) && $_POST['type_faq'] == $k) || $k == 0? 'selected' : "")?>>
                <?=$v?>
              </option>
            <?php } ?>
          </select>
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
      <a class="back-url" href="/admin/static/faq/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab"><?=$messG['Настройки']?></li>
    </ul>

    <form class="content-form" action="" method="post" enctype="multipart/form-data">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="input-value">
          <div class="name-section">Active:</div>
          <input type="checkbox" <?=((isset($error, $_POST['active']) || ($arResult['active'] == 1 && !isset($error)))? "checked" : "")?> name="active" value="1">
        </div>

        <div class="input-value">
          <div class="name-section"><?=$messG['Сортування']?>:</div>
          <input type="number" name="sort" value="<?=(isset($error)? (int)$_POST['sort'] : $arResult['sort'])?>">
        </div>

        <div class="input-value">
          <div class="name-section">Question:<span class="accent">*</span></div>
          <input <?=(isset($check['question'])? $check['question'] : '')?> type="text" name="question" value="<?=(isset($error)? hsc($_POST['question']) : $arResult['question'])?>">
        </div>

        <div class="input-value">
          <div class="name-section">Type FAQ:<span class="accent">*</span></div>
          <select name="type_faq">
            <?php foreach($messG['type_faq'] as $k => $v){ ?>
              <option value="<?=$k?>" <?=(((isset($error) && $_POST['type_faq'] == $k) || ((int)$arResult['type_faq'] == $k))? 'selected' : "")?>>
                <?=$v?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value redactor">
          <div class="name-section">Answer:<span class="accent">*</span></div>
          <textarea <?=(isset($check['answer'])? $check['answer'] : '')?> name="answer"><?=((isset($error))? hsc($_POST['answer']) : $arResult['answer'])?></textarea>
        </div>

        <div class="input-value upload_file">
          <?php foreach($_POST['img'] as $key => $file){ ?>
            <div class="input-value upload_file" id="img_<?=$key?>" data-priority-type="img">
              <?php $exist_file = fileExist($file); ?>
              <button type="button" onclick="getIdElement(this)">
                <span class="icon-link"></span><?=(!empty($exist_file)? basename($file) : 'Select file')?>
              </button>
              <input name="img[]" type="hidden" value="<?=(!empty($exist_file)? $file : '')?>">
              <input name="del[img][]" type="hidden" value="<?=(isset($_POST['del']['img'][$key])? hsc($_POST['del']['img'][$key]) : $file)?>">
              <div class="photos <?=(!empty($exist_file)? '' : 'hidden')?>">
                <span class="icon-cross removeFile" onclick="removeImage(this)"></span> <img src="<?=$exist_file?>">
              </div>
            </div>
          <?php } ?>

          <div class="add_more" data-input-more="img"><?=$messG['Добавити ще']?></div>
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
      <a href="/admin/static/faq/?filterReset=ok"><?=$messG['Відмінити']?></a>
    </form>
  </div>

  <div class="section-interface-k1">
    <div class="line-custom">
      <p class="header-name">FAQ</p>
    </div>

    <form action="" method="post" onsubmit="return okFrom();">
      <div class="line-custom-next">
        <a href="/admin/static/faq/?add=ok" class="add-el icon-plus"><?=$messG['Створити елемент']?></a>
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
                  <a href="/admin/static/faq/?edit=<?=$arResult['id']?>"><?=$messG['Редагувати']?></a>
                  <a href="/admin/static/faq/?delete=<?=$arResult['id']?>"><?=$messG['Видалити']?></a>
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