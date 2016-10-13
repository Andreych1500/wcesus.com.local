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
    <h1>WCES Services</h1>
    <p>WCES is the international credential evaluation service provider in the U.S. WCES offers a range of services both for individuals and institutions. WCES enables to recognize the outside of the U.S. educational programs academic credentials.</p>

    <p>WCES provides accurate credential evaluations reports for students, job seekers, and immigrants to prove their academic history, excellence, and achievements. WCES present opportunities to demonstrate extraordinary skills for education, employment, and immigration purposes.</p>

    <p>WCES uses research tools to cooperate with academic institutions, ministries of education and other educational authorities across the globe.</p>

    <p>WCES shares its research with credential evaluation agencies for proper results. WCES examine international experience and evaluate reports based on the research consulting solutions.</p>
  </div>
</div>