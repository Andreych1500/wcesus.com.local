<div class="section-interface-k2">
  <div class="line-custom-edit">
    <p class="header-name-edit"><?=$mess['Експорт таблиць']?></p>
  </div>

  <!-- Menu tabs --->
  <ul class="tabs-panel">
    <li class="active-tab"><?=$messG['Настройки']?></li>
  </ul>

  <form class="content-form" action="" method="post">

    <!-- Element tabs -->
    <div class="tabs active-block-tabs">
      <div class="input-value">
        <div class="name-section"><?=$mess['Тип експорту']?>:</div>
        <div class="input-radio">
          <label><span>MYSQL</span><input checked type="radio" name="export" value="mysql"></label>
          <span class="or">|</span>
          <label><span>CSV</span><input type="radio" name="export" value="csv"></label>
          <span class="or">|</span>
          <label><span>XLS</span><input type="radio" name="export" value="xls"></label>
        </div>
      </div>

      <div class="input-value">
        <div class="name-section"><?=$mess['База даних']?>:</div>
        <div class="silver_text" data-get-dbTable-ajax="ok"><?=Core::$DB_NAME?></div>
      </div>
    </div>

    <div class="technik-off-onn">
      <?=$mess['Вибір таблиць']?>:
      <label class="all_cheked"><input type="checkbox" name="all_cheked">All</label>
      <div class="checkbox-section" data-result="tables"></div>
    </div>

    <input type="submit" value="<?=$mess['Експорт']?>" name="ok">
    <a class="silver-submit" href="/admin/setting/export-db/?download=ok"><?=$mess['Скачати останній файл']?></a>
  </form>
</div>