<?php if(isset($_REQUEST['edit'])){ ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Редагування елемента']?></p>
      <a class="back-url" href="/admin/cab/copy-agency/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab">Card</li>
    </ul>

    <form class="content-form" action="" method="post">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">

        <div class="input-value">
          <div class="name-section">Text copy:<span class="accent">*</span></div>
          <textarea class="big-height <?=(isset($check['text_copy'])? $check['text_copy'] : '')?>" name="text_copy"><?=(isset($error) || isset($_POST['text_copy'])? hsc($_POST['text_copy']) : "")?></textarea>
        </div>

        <div class="input-value">
          <div class="name-section">Mailing Options:<span class="accent">*</span></div>
          <br>
          <?php foreach($param['mailing_copy'] as $k => $v){ ?>
            <label><input type="radio" name="mailing_copy" value="<?=$k?>" <?=(isset($check['mailing_copy'])? $check['mailing_copy'] : '')?> <?=(isset($_POST['mailing_copy']) && $_POST['mailing_copy'] == $k || $k == 0? 'checked' : "")?>><?=$v['text']?>($<?=$v['price']?>)
            </label>
          <?php } ?>
        </div>
      </div>
      <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
    </form>

    <form action="" id="to_file" enctype="multipart/form-data">
      <input id="control" type="file" name="file" onchange="addFile(this)" data-input="" data-name-submit="Select file">
    </form>
  </div>
<?php } else { ?>
  <div class="filter">
    <div class="filter-name"><?=$messG['Фільтр']?></div>
    <form action="" method="get">
      <div class="add-field-filter icon-plus"></div>
      <div class="filter-option-list">
        <?php foreach($copyAgency['setting_column'] as $k => $value){
          if($value['view_filter']){
            echo '<div class="'.(isset($_COOKIE['filter']) && in_array($value['index'], (array)json_decode($_COOKIE['filter']))? 'act-option' : '').'" data-index="'.(int)$value['index'].'">'.$value['name'].'</div>';
          }
        } ?>
      </div>
      <?=$copyAgency['html_filter']?>
      <input type="submit" name="filter" value="<?=$messG['Пошук']?>">
      <a href="/admin/cab/copy-agency/?filterReset=ok"><?=$messG['Відмінити']?></a>
    </form>
  </div>

  <div class="section-interface-k1">
    <div class="line-custom">
      <p class="header-name">Додаткові копії</p>
    </div>

    <form action="" method="post" onsubmit="return okFrom();">
      <div class="line-custom-next">
        <a href="/admin/cab/copy-agency/?add=ok" class="add-el icon-plus"><?=$messG['Створити елемент']?></a>
        <input type="submit" value="<?=$messG['Активувати']?>" name="activate" class="option-el">
        <input type="submit" value="<?=$messG['Деактивувати']?>" name="deactivate" class="option-el">
        <input type="submit" value="<?=$messG['Видалити']?>" name="delete" class="option-el">
        <div class="dynamicEdit" data-submit-lang="<?=$messG['Зберегти'].'|'.$messG['Відмінити']?>"></div>
      </div>

      <table class="illustration-table">
        <tr>
          <td><input type="checkbox" name="all_cheked"></td>
          <td></td>
          <?php foreach($copyAgency['column_list'] as $k => $v){
            if($copyAgency['setting_column'][$v]['view_table']){ ?>
              <td><?=$copyAgency['setting_column'][$v]['name']?></td>
            <?php }
          } ?>
        </tr>

        <?php if($copyAgency['result_DB']->num_rows > 0){
          while($arResult = hsc($copyAgency['result_DB']->fetch_assoc())){ ?>
            <tr data-id="<?=$arResult['id']?>">
              <td><input type="checkbox" name="ids[]" value="<?=$arResult['id']?>"></td>
              <td class="relative">
                <span class="icon-mob-menu" onclick="openMenuUpdate(this);"></span>
                <div class="menu-update">
                  <a href="/admin/cab/copy-agency/?edit=<?=$arResult['id']?>"><?=$messG['Редагувати']?></a>
                  <a href="/admin/cab/copy-agency/?delete=<?=$arResult['id']?>"><?=$messG['Видалити']?></a>
                </div>
              </td>
              <?php foreach($arResult as $k => $value){
                if($copyAgency['setting_column'][$k]['view_table']){ ?>
                  <td <?=(($copyAgency['setting_column'][$k]['edit_window'] == 1)? 'data-field="'.$k.'"' : '')?>><?=(($copyAgency['setting_column'][$k]['field'] == 'tinyint')? $messG[$k][$value] : $value)?></td>
                <?php }
              } ?>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td>-</td>
            <td>-</td>
            <?php foreach($copyAgency['setting_column'] as $k => $v){
              if($v['view_table']){ ?>
                <td>-</td>
              <?php }
            } ?>
          </tr>
        <?php } ?>
      </table>
    </form>

    <div class="bottom-table">
      <?=$copyAgency['count_el_page']?>
      <?=$copyAgency['pagination']?>
    </div>
  </div>
<?php } ?>