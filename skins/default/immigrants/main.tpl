<div class="clear-fix">
  <div class="main-free-item">
    <?php foreach($arBlock as $k => $v){ ?>
      <div class="course-item">
        <div class="course-hover">
          <img src="<?=$v['img']?>" alt="<?=$v['alt_img']?>">
          <div class="hover-bg"></div>
          <a href="/apply/">Apply Now</a>
        </div>

        <div class="course-name">
          <span class="price"><?=$v['price']?></span>
          <div><?=$v['name']?></div>
        </div>

        <div class="course-desc">
          <div class="desc-text"><?=$v['description']?></div>
          <div class="divider"></div>
          <div class="reqDoc">
            <a href="/immigrants/required-documents/">Required Documents</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <div class="apply-user wces-padding">
    <p>NOTE: This is the standard list of required documents for
      <a href="https://www.uscis.gov/">USCIS</a>. WCES is strongly advising you to contact your immigration lawyer or
      <a href="https://www.uscis.gov/">USCIS</a> office for the particular of the evaluation report.</p>
  </div>

  <ul class="apply-user wces-padding">
    <li>Copies of official transcripts</li>
    <li>Certified copies of the actual degree, diploma, certificate or similar award</li>
    <li>Any other official documentation from the school’s Office of the Registrar</li>
    <li>An evaluation from an educational evaluation agency, if you obtained your degree outside the United States</li>
  </ul>
</div>