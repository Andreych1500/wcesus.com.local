<div class="clear-fix bottom-20px">
  <?php if($main_banner->num_rows > 0){ ?>
  <div class="main-banner">
    <div class="slide-list">
      <?php
      $j = 0;
      while($arResult = $main_banner->fetch_assoc()){ ?>
        <div class="slide-item <?=(($j == 0)? 'active-slide' : '')?>">
          <img src="<?=hsc($arResult['img'])?>" title="<?=hsc($arResult['img_seo_title'])?>" alt="<?=hsc($arResult['img_seo_alt'])?>">
        </div>
        <?php ++$j;
      } ?>
      <div class="row-slide">
        <?php for($i = 0; $i < $j; ++$i){ ?>
          <span class="<?=(($i == 0)? 'active-row' : '')?>"></span>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>

  <hr class="divider-color">

  <div class="grid-row">
    <h1>Our Services</h1>
    <p>Donec sollicitudin lacus in felis luctus blandit. Ut hendrerit mattis justo at susp. Vivamus orci urna, ornare vitae tellus in, condimentum imperdiet eros. Maecea accumsan, massa nec vulputate congue. Maecenas nec odio et ante tincidunt creptus alarimus tempus.</p>
  </div>
</div>