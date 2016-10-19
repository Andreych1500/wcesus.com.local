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
            <a href="/job-seekers/required-documents/">Required Documents</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <ul class="apply-user wces-padding">
    <li>A WCES foreign credential evaluation makes it easier for employers to understand your educational history, courses, degree, and grades in U.S. terms.</li>
    <li>Some U.S. Employers require specific instructions while preparing the documents and mailing them. Please contact your U.S. Employer before mailing official documents, submitting the evaluation report, and other if needed.</li>
    <li>Some U.S. Employers require Course-by-Course Evaluation Report. Please contact your U.S. Employer before submitting evaluation report.</li>
    <li>Please request Certification Form for all Certifications.</li>
  </ul>
</div>