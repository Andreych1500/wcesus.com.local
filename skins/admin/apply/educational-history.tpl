<?php if(isset($_GET['edit'])){ ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Редагування елемента']?></p>
      <a class="back-url" href="/admin/apply/educational-history/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab">History</li>
    </ul>

    <form class="content-form" action="" method="post">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="input-value">
          <div class="name-section">County:<span class="accent">*</span></div>
          <select name="country_study" <?=(isset($check['country_study'])? $check['country_study'] : '')?>>
            <?php foreach($param['country_study'] as $k => $v){ ?>
              <option value="<?=$k?>" <?=((isset($_POST['country_study']) && $_POST['country_study'] == $k || $k === 0)? 'selected' : "")?>>
                <?=$v?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value">
          <div class="name-section">City:<span class="accent">*</span></div>
          <input <?=(isset($check['city'])? $check['city'] : '')?> type="text" name="city" value="<?=(isset($_POST['city'])? hsc($_POST['city']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section">Name of Institution:<span class="accent">*</span></div>
          <input <?=(isset($check['name_institution'])? $check['name_institution'] : '')?> type="text" name="name_institution" value="<?=(isset($_POST['name_institution'])? hsc($_POST['name_institution']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section">Dates Attended <b>From</b> (mm): <span class="accent">*</span></div>
          <select name="date_mm_from" <?=(isset($check['date_mm_from'])? $check['date_mm_from'] : '')?>>
            <?php foreach($param['date_mm_from'] as $k => $v){ ?>
              <option value="<?=$k?>" <?=((isset($_POST['date_mm_from']) && $_POST['date_mm_from'] == $k || $k === 0)? 'selected' : "")?>>
                <?=$v?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value">
          <div class="name-section">Dates Attended <b>From</b> (yyyy): <span class="accent">*</span></div>
          <select name="date_yyyy_from" <?=(isset($check['date_yyyy_from'])? $check['date_yyyy_from'] : '')?>>
            <?php foreach($param['date_yyyy_from'] as $k => $v){ ?>
              <option value="<?=$k?>" <?=((isset($_POST['date_yyyy_from']) && $_POST['date_yyyy_from'] == $k || $k === 0)? 'selected' : "")?>>
                <?=$v?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value">
          <div class="name-section">Dates Attended <b>To</b> (mm): <span class="accent">*</span></div>
          <select name="date_mm_to" <?=(isset($check['date_mm_to'])? $check['date_mm_to'] : '')?>>
            <?php foreach($param['date_mm_to'] as $k => $v){ ?>
              <option value="<?=$k?>" <?=((isset($_POST['date_mm_to']) && $_POST['date_mm_to'] == $k || $k === 0)? 'selected' : "")?>>
                <?=$v?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value">
          <div class="name-section">Dates Attended <b>To</b> (yyyy): <span class="accent">*</span></div>
          <select name="date_yyyy_to" <?=(isset($check['date_yyyy_to'])? $check['date_yyyy_to'] : '')?>>
            <?php foreach($param['date_yyyy_to'] as $k => $v){ ?>
              <option value="<?=$k?>" <?=((isset($_POST['date_yyyy_to']) && $_POST['date_yyyy_to'] == $k || $k === 0)? 'selected' : "")?>>
                <?=$v?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="input-value">
          <div class="name-section">Name of Diploma or Certificate, if Awarded:</div>
          <input type="text" name="diploma_name" value="<?=(isset($_POST['diploma_name'])? hsc($_POST['diploma_name']) : '')?>">
        </div>

        <div class="input-value">
          <div class="name-section">If there was a significantly large gap in time between the date of completion of the program and the date of the award of the qualification, please explain why below (limit 1000 characters):</div>
          <textarea <?=(isset($check['reason_text'])? $check['reason_text'] : '')?> name="reason_text"><?=(isset($_POST['reason_text'])? hsc($_POST['reason_text']) : "")?></textarea>
        </div>

        <div class="line-input-two">
          <div class="header-inputs <?=(isset($check['fileScan'])? $check['fileScan'] : '')?>">File scan (only: JPG, PNG, GIF):
            <span class="accent">*</span></div>

          <?php foreach($_POST['fileScan'] as $key => $file){ ?>
            <div class="input-value upload_file" id="fileScan_<?=$key?>" data-priority-type="img">
              <?php $exist_file = fileExist($file); ?>
              <button type="button" onclick="getIdElement(this)">
                <span class="icon-link"></span><?=(!empty($exist_file)? basename($file) : 'Select file')?>
              </button>
              <input name="fileScan[]" type="hidden" value="<?=(!empty($exist_file)? $file : '')?>">
              <input name="del[fileScan][]" type="hidden" value="<?=(isset($_POST['del']['fileScan'][$key])? hsc($_POST['del']['fileScan'][$key]) : $file)?>">
              <div class="photos <?=(!empty($exist_file)? '' : 'hidden')?>">
                <span class="icon-cross removeFile" onclick="removeImage(this)"></span> <img src="<?=$exist_file?>">
              </div>
            </div>
          <?php } ?>

          <div class="add_more">Add more</div>
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
        <?php foreach($history['setting_column'] as $k => $value){
          if($value['view_filter']){
            echo '<div class="'.(isset($_COOKIE['filter']) && in_array($value['index'], (array)json_decode($_COOKIE['filter']))? 'act-option' : '').'" data-index="'.(int)$value['index'].'">'.$value['name'].'</div>';
          }
        } ?>
      </div>
      <?=$history['html_filter']?>
      <input type="submit" name="filter" value="<?=$messG['Пошук']?>">
      <a href="/admin/apply/educational-history/?filterReset=ok"><?=$messG['Відмінити']?></a>
    </form>
  </div>

  <div class="section-interface-k1">
    <div class="line-custom">
      <p class="header-name">Educational History</p>
    </div>

    <form action="" method="post" onsubmit="return okFrom();">
      <div class="line-custom-next">
        <input type="submit" value="<?=$messG['Видалити']?>" name="delete" class="option-el">
        <div class="dynamicEdit" data-submit-lang="<?=$messG['Зберегти'].'|'.$messG['Відмінити']?>"></div>
      </div>

      <table class="illustration-table">
        <tr>
          <td><input type="checkbox" name="all_cheked"></td>
          <td></td>
          <?php foreach($history['column_list'] as $k => $v){
            if($history['setting_column'][$v]['view_table']){ ?>
              <td><?=$history['setting_column'][$v]['name']?></td>
            <?php }
          } ?>
        </tr>

        <?php if($history['result_DB']->num_rows > 0){
          while($arResult = hsc($history['result_DB']->fetch_assoc())){ ?>
            <tr data-id="<?=$arResult['id']?>">
              <td><input type="checkbox" name="ids[]" value="<?=$arResult['id']?>"></td>
              <td class="relative">
                <span class="icon-mob-menu" onclick="openMenuUpdate(this);"></span>
                <div class="menu-update">
                  <a href="/admin/apply/educational-history/?edit=<?=$arResult['id']?>"><?=$messG['Редагувати']?></a>
                  <a href="/admin/apply/educational-history/?delete=<?=$arResult['id']?>"><?=$messG['Видалити']?></a>
                </div>
              </td>
              <?php foreach($arResult as $k => $value){
                if($history['setting_column'][$k]['view_table']){ ?>
                  <td <?=(($history['setting_column'][$k]['edit_window'] == 1)? 'data-field="'.$k.'"' : '')?>><?=(($history['setting_column'][$k]['field'] == 'tinyint')? $messG[$k][$value] : $value)?></td>
                <?php }
              } ?>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td>-</td>
            <td>-</td>
            <?php foreach($history['setting_column'] as $k => $v){
              if($v['view_table']){ ?>
                <td>-</td>
              <?php }
            } ?>
          </tr>
        <?php } ?>
      </table>
    </form>

    <div class="bottom-table">
      <?=$history['count_el_page']?>
      <?=$history['pagination']?>
    </div>
  </div>
<?php } ?>