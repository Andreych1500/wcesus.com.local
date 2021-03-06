<form class="clear-fix bg-net" action="/apply/purpose/" method="post">
  <div class="steps">
    <?php for($i = 1; $i <= 7; ++$i){ ?>
      <div <?=($i == 3? 'class="active"' : '')?>>Step <?=$i?></div>
    <?php } ?>
  </div>

  <div class="header-question">Purpose</div>

  <div class="section-question">Application Purpose</div>
  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">What is the <b>main</b> purpose of your evaluation: <span class="accent">*</span></div>
      <select name="main_purpose" <?=(isset($check['main_purpose'])? $check['main_purpose'] : '')?>>
        <?php foreach($param['main_purpose'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['main_purpose']) && $_POST['main_purpose'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="input-value <?=($_POST['main_purpose'] == 4? '' : 'hidden')?>" data-section="4">
      <div class="name-section">Please specify:<span class="accent">*</span></div>
      <input <?=(isset($check['please_spec'])? $check['please_spec'] : '')?> type="text" name="please_spec" value="<?=$_POST['please_spec']?>">
    </div>
  </div>

  <div class="section-question <?=($_POST['main_purpose'] == 1? '' : 'hidden')?>" data-section="1">For Admission to</div>
  <div class="line-input <?=($_POST['main_purpose'] == 1? '' : 'hidden')?>" data-section="1">
    <div class="input-value">
      <div class="name-section">Please note that there are 5 types:<span class="accent">*</span></div>
      <div class="checkbox-div">
        <?php foreach($param['admission_to'] as $k => $v){ ?>
          <label>
            <input <?=(isset($check['admission_to'])? $check['admission_to'] : '')?> type="checkbox" name="admission_to[]" value="<?=$k?>"
              <?=(in_array($k, $_POST['admission_to'])? 'checked' : "")?>><?=$v?>
          </label>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="section-question" <?=($_POST['main_purpose'] != 0? '' : 'hidden')?> data-hidden="main_purpose">Document Requirements</div>
  <div class="line-input" <?=($_POST['main_purpose'] != 0? '' : 'hidden')?> data-hidden="main_purpose">
    <div class="input-value">
      <div class="name-section">Please note that there is Document Requirements:<span class="accent">*</span>
      </div>
      <ul class="list-info">
        <li><span class="accent">*</span> WCES Country-Specific Requirements</li>
      </ul>

      <div class="name-section link-style-1">I have reviewed and understood the
        <a href="/for-students/required-documents/" data-section="1">Document Requirements</a>
        <a href="/job-seekers/required-documents/" data-section="2">Document Requirements</a>
        <a href="/immigrants/required-documents/" data-section="3">Document Requirements</a>
        <span data-section="4">Document Requirements</span> outlined above:</div>
      <select name="document_requirements" <?=(isset($check['document_requirements'])? $check['document_requirements'] : '')?>>
        <?php foreach($param['document_requirements'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['document_requirements']) && $_POST['document_requirements'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="section-question <?=($_POST['main_purpose'] == 1? '' : 'hidden')?>" data-section="1">Additional Requirements for Educational Institutions</div>
  <div class="line-input <?=($_POST['main_purpose'] == 1? '' : 'hidden')?>" data-section="1">
    <div class="input-value">
      <p>Some educational institutions require that the evaluation be addressed and mailed directly to them. It is recommended that you check directly with the officials there and confirm their mailing requirements.</p>
    </div>
  </div>

  <div class="section-question <?=($_POST['main_purpose'] != 0? '' : 'hidden')?>" data-hidden="main_purpose">Report Type</div>
  <div class="line-input <?=($_POST['main_purpose'] != 0? '' : 'hidden')?>" data-hidden="main_purpose">
    <div class="input-value">
      <?php foreach($param['report_type_text'] as $k => $v){ ?>
        <i class="<?=($_POST['main_purpose'] == $k? '' : 'hidden')?>" data-section="<?=$k?>"><?=$v?></i>
      <?php } ?>

      <div class="name-section">Please select one of the following reports:<span class="accent">*</span></div>
      <div class="items-report">
        <?php foreach($param['report_type'] as $k => $v){ ?>
          <div>
            <label>
              <input type="radio" name="report_type[]" value="<?=$k?>" <?=(isset($check['report_type'])? $check['report_type'] : '')?> <?=((is_array($_POST['report_type']) && in_array($k, $_POST['report_type'])) || $k == 0? 'checked' : "")?>>
              <b><?=$v['name']?></b> </label> <a href="<?=$v['sample']?>">Sample Report</a>
            <span>$<?=$v['price']?></span>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <input type="hidden" name="update" value="<?=$_POST['update']?>">

  <div class="save-or-continue">
    <a href="/apply/education-history/" title="application-info" class="back_link">< Back</a>
    <input type="submit" name="ok" value="Continue >" class="<?=($_POST['main_purpose'] != 0? '' : 'hidden')?>" data-hidden="main_purpose">
  </div>
</form>