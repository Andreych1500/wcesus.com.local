<div class="section-interface-k1">
  <div class="line-custom">
    <p class="header-name"><?=$mess['Оновлення кеш файлів']?></p>
  </div>

  <table class="illustration-table">
    <tr>
      <td>№</td>
      <td><?=$mess['Версія кешу']?></td>
      <td><?=$messG['Час оновлення']?></td>
      <td><?=$messG['Ким оновлений']?></td>
    </tr>
    <tr>
      <td><?=(int)$arResult['number_cache']?></td>
      <td><?=(int)$arResult['new_resource']?></td>
      <td><?=hsc($arResult['date_custom'])?></td>
      <td><?=hsc($arResult['user_custom'])?></td>
    </tr>
  </table>
  <div class="bottom-table">
    <a class="reload-file" href="/admin/setting/update-files/?reload=ok"><?=$mess['Поновити кеш файлів']?></a>
  </div>
</div>