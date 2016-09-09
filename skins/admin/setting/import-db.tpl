<div class="section-interface-k2">
  <div class="line-custom-edit">
    <p class="header-name-edit"><?=$mess['Імпорт даних']?></p>
  </div>

  <!-- Menu tabs --->
  <ul class="tabs-panel">
    <li class="active-tab"><?=$messG['Настройки']?></li>
  </ul>

  <form class="content-form" action="" method="post" enctype="multipart/form-data">

    <!-- Element tabs -->
    <div class="tabs active-block-tabs">
      <div class="input-value">
        <div class="name-section"><?=$mess['Тип файлу']?>:</div>
        <select name="type_import">
          <option value="sql">sql</option>
          <option value="csv">csv</option>
        </select>
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Вид імпорту']?>:</div>
        <select name="what_option">
          <option value="new_import"><?=$mess['Новий імпорт']?></option>
          <option value="replace_all"><?=$mess['Замінити повністю']?></option>
          <option value="add_elements"><?=$mess['Імпорт елементів']?></option>
          <option data-option="csv" disabled value="add_csv_elements"><?=$mess['Замінити повністю']?></option>
        </select>
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['Вид імпорту']?>:</div>
        <input type="file" name="file">
      </div>
    </div>

    <input type="submit" value="<?=$mess['Імпорт']?>" name="ok">
  </form>
</div>