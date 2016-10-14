<div class="clear-fix apply-user">
  <div class="header-question">Site Map WCES</div>

  <ul class="site_map_list">
    <?php foreach($site_map as $name => $v){
      if(is_array($v)){ ?>
        <li class="section"><a href="<?=$v['this']?>" title="<?=$name?>"><?=$name?></a>
          <?php unset($v['this']); ?>
          <ul>
            <?php foreach($v as $name2 => $v2){ ?>
              <li><a href="<?=$v2?>" title="<?=$name2?>"><?=$name2?></a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } else { ?>
        <li><a href="<?=$v?>" title="<?=$name?>"><?=$name?></a></li>
      <?php }
    }
    ?>
  </ul>
</div>