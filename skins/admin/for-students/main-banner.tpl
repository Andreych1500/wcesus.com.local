<?php if(isset($_GET['add'])){ ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Створити елемент']?></p>
      <a class="back-url" href="/admin/for-students/main-banner/"><?=$messG['Назад']?></a>
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
          <div class="name-section"><?=$messG['Сортування']?>:</div>
          <input type="number" name="sort" value="<?=(isset($error)? (int)$_POST['sort'] : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section">Name:<span class="accent">*</span></div>
          <input <?=(isset($check['name'])? $check['name'] : '')?> type="text" name="name" value="<?=(isset($error)? hsc($_POST['name']) : "")?>">
        </div>

        <div class="header-line"><?=$messG['Увага!']?></div>
      </div>

      <input type="submit" value="<?=$messG['Створити']?>" name="ok">
    </form>

    <form action="" id="to_file" enctype="multipart/form-data">
      <input id="control" type="file" name="file" onchange="addFile(this)" data-input="" data-name-submit="<?=$messG['Вибрати файл']?>">
    </form>
  </div>
<?php } elseif(isset($_GET['edit'])) { ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Редагування елемента']?></p>
      <a class="back-url" href="/admin/for-students/main-banner/"><?=$messG['Назад']?></a>
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
          <div class="name-section">Sort:</div>
          <input type="number" name="sort" value="<?=(isset($error)? (int)$_POST['sort'] : $arResult['sort'])?>">
        </div>

        <div class="input-value">
          <div class="name-section">Name:<span class="accent">*</span></div>
          <input <?=(isset($check['name'])? $check['name'] : '')?> type="text" name="name" value="<?=(isset($error)? hsc($_POST['name']) : $arResult['name'])?>">
        </div>

        <div class="input-value">
          <div class="name-section">Img title:</div>
          <input type="text" name="img_seo_title" value="<?=(isset($error)? hsc($_POST['img_seo_title']) : $arResult['img_seo_title'])?>">
        </div>

        <div class="input-value">
          <div class="name-section">Img Alt:</div>
          <input type="text" name="img_seo_alt" value="<?=(isset($error)? hsc($_POST['img_seo_alt']) : $arResult['img_seo_alt'])?>">
        </div>

        <div class="input-value upload_file" id="img" data-priority-type="img">
          <div class="name-section">Image:</div>
          <?php $file = (isset($error) && !empty($_POST['img'])? hsc($_POST['img']) : $arResult['img']);
          $exist_file = fileExist($file);
          $size = (!empty($exist_file)? getimagesize($_SERVER['DOCUMENT_ROOT'].$file)[0] : 'auto');
          ?>
          <button type="button" onclick="getIdElement(this)">
            <span class="icon-link"></span><?=(!empty($exist_file)? $file : $messG['Вибрати файл'])?>
          </button>
          <input name="img" type="hidden" value="<?=(!empty($exist_file)? $file : '')?>">
          <input name="del[img]" type="hidden" value="<?=(isset($_POST['del']['img'])? hsc($_POST['del']['img']) : $arResult['img'])?>">
          <div class="photos <?=(!empty($exist_file)? '' : 'hidden')?>">
            <span class="icon-cross removeFile" onclick="removeImage(this)"></span>
            <img src="<?=$exist_file?>" width="<?=$size?>">
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
        <?php foreach($main_banner['setting_column'] as $k => $value){
          if($value['view_filter']){
            echo '<div class="'.(isset($_COOKIE['filter']) && in_array($value['index'], (array)json_decode($_COOKIE['filter']))? 'act-option' : '').'" data-index="'.(int)$value['index'].'">'.$value['name'].'</div>';
          }
        } ?>
      </div>
      <?=$main_banner['html_filter']?>
      <input type="submit" name="filter" value="<?=$messG['Пошук']?>">
      <a href="/admin/for-students/main-banner/?filterReset=ok"><?=$messG['Відмінити']?></a>
    </form>
  </div>

  <div class="section-interface-k1">
    <div class="line-custom">
      <p class="header-name">Main Banners</p>
    </div>

    <form action="" method="post" onsubmit="return okFrom();">
      <div class="line-custom-next">
        <a href="/admin/for-students/main-banner/?add=ok" class="add-el icon-plus"><?=$messG['Створити елемент']?></a>
        <input type="submit" value="<?=$messG['Активувати']?>" name="activate" class="option-el">
        <input type="submit" value="<?=$messG['Деактивувати']?>" name="deactivate" class="option-el">
        <input type="submit" value="<?=$messG['Видалити']?>" name="delete" class="option-el">
        <div class="dynamicEdit" data-submit-lang="<?=$messG['Зберегти'].'|'.$messG['Відмінити']?>"></div>
      </div>

      <table class="illustration-table">
        <tr>
          <td><input type="checkbox" name="all_cheked"></td>
          <td></td>
          <?php foreach($main_banner['column_list'] as $k => $v){
            if($main_banner['setting_column'][$v]['view_table']){ ?>
              <td><?=$main_banner['setting_column'][$v]['name']?></td>
            <?php }
          } ?>
        </tr>

        <?php if($main_banner['result_DB']->num_rows > 0){
          while($arResult = hsc($main_banner['result_DB']->fetch_assoc())){ ?>
            <tr data-id="<?=$arResult['id']?>">
              <td><input type="checkbox" name="ids[]" value="<?=$arResult['id']?>"></td>
              <td class="relative">
                <span class="icon-mob-menu" onclick="openMenuUpdate(this);"></span>
                <div class="menu-update">
                  <a href="/admin/for-students/main-banner/?edit=<?=$arResult['id']?>"><?=$messG['Редагувати']?></a>
                  <a href="/admin/for-students/main-banner/?delete=<?=$arResult['id']?>"><?=$messG['Видалити']?></a>
                </div>
              </td>
              <?php foreach($arResult as $k => $value){
                if($main_banner['setting_column'][$k]['view_table']){ ?>
                  <td <?=(($main_banner['setting_column'][$k]['edit_window'] == 1)? 'data-field="'.$k.'"' : '')?>><?=(($main_banner['setting_column'][$k]['field'] == 'tinyint')? $messG[$k][$value] : $value)?></td>
                <?php }
              } ?>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td>-</td>
            <td>-</td>
            <?php foreach($main_banner['setting_column'] as $k => $v){
              if($v['view_table']){ ?>
                <td>-</td>
              <?php }
            } ?>
          </tr>
        <?php } ?>
      </table>
    </form>

    <div class="bottom-table">
      <?=$main_banner['count_el_page']?>
      <?=$main_banner['pagination']?>
    </div>
  </div>
<?php } ?>