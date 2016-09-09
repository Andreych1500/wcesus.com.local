<div class="section-interface-k1">
  <div class="line-custom">
    <p class="header-name"><?=$mess['Резервне копіювання проекту']?></p>
  </div>

  <table class="illustration-table">
    <tr>
      <td>№</td>
      <td><?=$mess['Файл бекапу']?></td>
      <td><?=$mess['Об\'єм пам\'яті']?></td>
      <td><?=$messG['Дата створення']?></td>
      <td><?=$messG['Ким оновлений']?></td>
    </tr>
    <?php if($backup['result_DB']->num_rows > 0){
      while($arResult = $backup['result_DB']->fetch_assoc()){ ?>
        <tr>
          <td><?=(int)$arResult['id']?></td>
          <td><?=hsc($arResult['file_name'])?></td>
          <td><?=hsc($arResult['volume_memory'])?></td>
          <td><?=hsc($arResult['date_create'])?></td>
          <td><?=hsc($arResult['user_custom'])?></td>
        </tr>
      <?php }
    } else { ?>
      <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
      </tr>
    <?php } ?>
  </table>
  <div class="bottom-table">
    <a class="reload-file" data-lang-text="<?=$mess['Зачекайте будь-ласка!']?>" href="/admin/setting/backup/?backup=ok"><?=$mess['Запустити backup']?></a>
    <a class="reload-file" href="/admin/setting/backup/?downloadBackup=ok"><?=$mess['Скачати останній backup']?></a>
    <?=$backup['pagination']?>
  </div>
</div>