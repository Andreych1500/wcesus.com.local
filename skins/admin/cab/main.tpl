<?php if(isset($_REQUEST['edit'])){ ?>
  <div class="section-interface-k2">
    <div class="line-custom-edit">
      <p class="header-name-edit"><?=$messG['Редагування елемента']?></p>
      <a class="back-url" href="/admin/cab/"><?=$messG['Назад']?></a>
    </div>

    <!-- Menu tabs --->
    <ul class="tabs-panel">
      <li class="active-tab">Card</li>
    </ul>

    <form class="content-form" action="" method="post">

      <!-- Element tabs -->
      <div class="tabs active-block-tabs">
        <div class="header-line">Applicant Information</div>

        <div class="input-value">
          <div class="name-section">Active:</div>
          <input type="checkbox" name="active" value="1" <?=(isset($_POST['active']) && $_POST['active'] == 1? 'checked' : "")?> <?=(isset($check['active'])? $check['active'] : '')?>>
        </div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">Last Name:<span class="accent">*</span></div>
            <input <?=(isset($check['last_name'])? $check['last_name'] : '')?> type="text" name="last_name" value="<?=(isset($error) || isset($_POST['last_name'])? hsc($_POST['last_name']) : '')?>">
          </div>

          <div class="input-value">
            <div class="name-section">First Name:<span class="accent">*</span></div>
            <input <?=(isset($check['first_name'])? $check['first_name'] : '')?> type="text" name="first_name" value="<?=(isset($error) || isset($_POST['first_name'])? hsc($_POST['first_name']) : '')?>">
          </div>

          <div class="input-value">
            <div class="name-section">Middle Name:</div>
            <input type="text" name="middle_name" value="<?=(isset($error) || isset($_POST['middle_name'])? hsc($_POST['middle_name']) : '')?>">
          </div>
        </div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">Is the Name on Your Educational Records Different Than That Above?:
              <span class="accent">*</span>
            </div>
            <select name="is_records_name" <?=(isset($check['is_records_name'])? $check['is_records_name'] : '')?>>
              <?php foreach($param[1]['is_records_name'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(((isset($_POST['is_records_name']) && $_POST['is_records_name'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="line-input <?=((isset($_POST['is_records_name']) && $_POST['is_records_name'] == 1)? '' : 'hidden')?>" data-disabled="is_records_name">
          <div class="input-value">
            <div class="name-section">Last Name (On Records):<span class="accent">*</span></div>
            <input <?=(isset($check['last_name_records'])? $check['last_name_records'] : '')?> type="text" name="last_name_records" value="<?=(isset($error) || isset($_POST['last_name_records'])? hsc($_POST['last_name_records']) : "")?>">
          </div>

          <div class="input-value">
            <div class="name-section">First Name (On Records):<span class="accent">*</span></div>
            <input <?=(isset($check['first_name_records'])? $check['first_name_records'] : '')?> type="text" name="first_name_records" value="<?=(isset($error) || isset($_POST['first_name_records'])? hsc($_POST['first_name_records']) : "")?>">
          </div>

          <div class="input-value">
            <div class="name-section">Middle Name (On Records):</div>
            <input type="text" name="middle_name_records" value="<?=(isset($error) || isset($_POST['first_name_records'])? hsc($_POST['middle_name_records']) : "")?>">
          </div>
        </div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">Date of Birth: (mm): <span class="accent">*</span></div>
            <select name="date_mm" <?=(isset($check['date_mm'])? $check['date_mm'] : '')?>>
              <?php foreach($param[1]['date_mm'] as $k => $v){ ?>
                <option value="<?=$v?>" <?=(((isset($_POST['date_mm']) && $_POST['date_mm'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$v?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="input-value">
            <div class="name-section">Date of Birth: (dd): <span class="accent">*</span></div>
            <select name="date_dd" <?=(isset($check['date_dd'])? $check['date_dd'] : '')?>>
              <?php foreach($param[1]['date_dd'] as $k => $v){ ?>
                <option value="<?=$v?>" <?=(((isset($_POST['date_dd']) && $_POST['date_dd'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$v?>
                </option>
              <?php } ?>
            </select>
          </div>
          <div class="input-value">
            <div class="name-section">Date of Birth: (yyyy): <span class="accent">*</span></div>
            <select name="date_yyyy" <?=(isset($check['date_yyyy'])? $check['date_yyyy'] : '')?>>
              <?php foreach($param[1]['date_yyyy'] as $k => $v){ ?>
                <option value="<?=$v?>" <?=(((isset($_POST['date_yyyy']) && $_POST['date_yyyy'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$v?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="input-value">
            <div class="name-section">Gender:<span class="accent">*</span></div>
            <select name="gender" <?=(isset($check['gender'])? $check['gender'] : '')?>>
              <?php foreach($param[1]['gender'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(((isset($_POST['gender']) && $_POST['gender'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">County:<span class="accent">*</span></div>
            <select name="country" <?=(isset($check['country'])? $check['country'] : '')?>>
              <?php foreach($param[1]['country'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(((isset($_POST['country']) && $_POST['country'] == $k) || !isset($error) && $k == '')? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="input-value">
            <div class="name-section">Address Line 1:<span class="accent">*</span></div>
            <input <?=(isset($check['addressOneLine'])? $check['addressOneLine'] : '')?> type="text" name="addressOneLine" value="<?=(isset($error) || isset($_POST['addressOneLine'])? hsc($_POST['addressOneLine']) : "")?>">
          </div>

          <div class="input-value">
            <div class="name-section">Address Line 2:<span class="accent">*</span></div>
            <input <?=(isset($check['addressTwoLine'])? $check['addressTwoLine'] : '')?> type="text" name="addressTwoLine" value="<?=(isset($error) || isset($_POST['addressTwoLine'])? hsc($_POST['addressTwoLine']) : "")?>">
          </div>
        </div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">City:<span class="accent">*</span></div>
            <input <?=(isset($check['city'])? $check['city'] : '')?> type="text" name="city" value="<?=(isset($error) || isset($_POST['city'])? hsc($_POST['city']) : "")?>">
          </div>

          <div class="input-value <?=((isset($_POST['country']) && $_POST['country'] == 'USA')? '' : 'hidden')?>" data-disabled="country-USA">
            <div class="name-section">State: <span class="accent">*</span>
            </div>
            <select name="state" <?=(isset($check['state'])? $check['state'] : '')?>>
              <?php foreach($param[1]['state'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(((isset($_POST['state']) && $_POST['state'] == $k) || !isset($error) && $k == '')? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="input-value <?=((isset($_POST['country']) && $_POST['country'] == 'USA')? '' : 'hidden')?>" data-disabled="country-USA">
            <div class="name-section">Zip Code:<span class="accent">*</span></div>
            <input <?=(isset($check['zip_code'])? $check['zip_code'] : '')?> type="text" name="zip_code" value="<?=(isset($error) || isset($_POST['country'])? hsc($_POST['zip_code']) : "")?>">
          </div>

          <div class="input-value <?=((!isset($_POST['country']) || $_POST['country'] != 'USA')? '' : 'hidden')?>" data-disabled="country-All">
            <div class="name-section">Region:<span class="accent">*</span></div>
            <input <?=(isset($check['region'])? $check['region'] : '')?> type="text" name="region" value="<?=(isset($error) || isset($_POST['region'])? hsc($_POST['region']) : "")?>">
          </div>

          <div class="input-value <?=((!isset($_POST['country']) || $_POST['country'] != 'USA')? '' : 'hidden')?>" data-disabled="country-All">
            <div class="name-section">Postal code:<span class="accent">*</span></div>
            <input <?=(isset($check['postal_code'])? $check['postal_code'] : '')?> type="text" name="postal_code" value="<?=(isset($error) || isset($_POST['postal_code'])? hsc($_POST['postal_code']) : "")?>">
          </div>
        </div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">Day Phone:<span class="accent">*</span></div>
            <input <?=(isset($check['phone'])? $check['phone'] : '')?> type="text" name="phone" value="<?=(isset($error) || isset($_POST['addressOneLine'])? hsc($_POST['phone']) : "")?>" placeholder="example: +1-000-000-0000">
          </div>

          <div class="input-value">
            <div class="name-section">Email Address:<span class="accent">*</span></div>
            <input <?=(isset($check['email'])? $check['email'] : '')?> type="text" name="email" value="<?=(isset($error) || isset($_POST['email'])? hsc($_POST['email']) : "")?>">
          </div>

          <div class="input-value">
            <div class="name-section">Cell Phone:</div>
            <input type="text" name="cell_phone" value="<?=(isset($error) || isset($_POST['cell_phone'])? hsc($_POST['cell_phone']) : "")?>">
          </div>
        </div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">How did you hear about us?: <span class="accent">*</span>
            </div>
            <select name="about_us" <?=(isset($check['about_us'])? $check['about_us'] : '')?>>
              <?php foreach($param[1]['about_us'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(((isset($_POST['about_us']) && $_POST['about_us'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="input-value <?=((isset($_POST['about_us']) && $_POST['about_us'] == 7)? '' : 'hidden')?>" data-disabled="about_us">
            <div class="name-section">Your answer:<span class="accent">*</span></div>
            <textarea <?=(isset($check['about_us_answer'])? $check['about_us_answer'] : '')?> name="about_us_answer"><?=(isset($error) || isset($_POST['about_us_answer'])? hsc($_POST['about_us_answer']) : "")?></textarea>
          </div>
        </div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">Have you ever previously used the services of IERF?: <span class="accent">*</span>
            </div>
            <select name="services_IERF" <?=(isset($check['services_IERF'])? $check['services_IERF'] : '')?>>
              <?php foreach($param[1]['services_IERF'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(((isset($_POST['services_IERF']) && $_POST['services_IERF'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="header-line">Educational History</div>
        <div class="spec-block-list">
          <?php if($history->num_rows > 0){
            while($arResHis = hsc($history->fetch_assoc())){ ?>
              Name institute :
              <a href="/admin/cab/history/?edit=<?=$arResHis['id']?>"><?=$arResHis['name_institution']?></a><br>
            <?php }
          } ?>
        </div>

        <div class="header-line">Purpose</div>
        <div class="line-input-two">
          <div class="input-value">
            <div class="name-section">What is the <b>main</b> purpose of your evaluation: <span class="accent">*</span>
            </div>
            <select name="main_purpose" <?=(isset($check['main_purpose'])? $check['main_purpose'] : '')?>>
              <?php foreach($param[3]['main_purpose'] as $k => $v){ ?>
                <option value="<?=$k?>" <?=($_POST['main_purpose'] == $k || !isset($error) && $k == 0? 'selected' : "")?>>
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
              <?php foreach($param[3]['admission_to'] as $k => $v){ ?>
                <label>
                  <input <?=(isset($check['admission_to'])? $check['admission_to'] : '')?> type="checkbox" name="admission_to[]" value="<?=$k?>" <?=(in_array($k, $_POST['admission_to']) && strlen($_POST['admission_to'][0]) > 0? 'checked' : "")?>><?=$v?>
                </label>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="line-input" <?=($_POST['main_purpose'] != 0? '' : 'hidden')?> data-disabled="main_purpose">
          <div class="input-value">
            <div class="name-section">I have reviewed and understood the Document Requirements outlined above:</div>
            <select name="document_requirements" <?=(isset($check['document_requirements'])? $check['document_requirements'] : '')?>>
              <?php foreach($param[3]['document_requirements'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(($_POST['document_requirements'] == $k || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="line-input <?=($_POST['main_purpose'] != 0? '' : 'hidden')?>" data-disabled="main_purpose">
          <div class="input-value">
            <div class="name-section">Please select one of the following reports:<span class="accent">*</span></div>
            <div class="items-report">
              <?php foreach($param[3]['report_type'] as $k => $v){ ?>
                <div>
                  <label>
                    <input type="radio" name="report_type[]" value="<?=$k?>" <?=(isset($check['report_type'])? $check['report_type'] : '')?> <?=((is_array($_POST['report_type']) && in_array($k, $_POST['report_type'])) || $k == 0? 'checked' : "")?>>
                    <b><?=$v['name']?></b> </label>
                  <span>$<?=$v['price']?></span>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="line-input <?=($_POST['main_purpose'] != 0? '' : 'hidden')?>" data-disabled="main_purpose">
          <div class="input-value">
            <div class="name-section">Please check any additional uses for your evaluation (if applicable):</div>
            <div class="checkbox-div">
              <?php foreach($param[3]['admission_ap_pur'] as $k => $v){ ?>
                <label data-check="<?=$k?>" <?=($_POST['main_purpose'] == $k? 'class="hiddenIM"' : '')?>>
                  <input type="checkbox" name="admission_ap_pur[]" value="<?=$k?>" <?=(is_array($_POST['admission_ap_pur']) && in_array($k, $_POST['admission_ap_pur'])? 'checked' : "")?>><?=$v?>
                </label>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="header-line">Mailing Instructions</div>

        <div class="line-input">
          <div class="input-value">
            <div class="name-section">Please mail my applicant copy and my original documents (if submitted) to:
              <span class="accent">*</span>
            </div>
            <select name="applicant_copy" <?=(isset($check['applicant_copy'])? $check['applicant_copy'] : '')?>>
              <?php foreach($param[4]['applicant_copy'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(((isset($_POST['applicant_copy']) && $_POST['applicant_copy'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="line-input-free <?=($_POST['applicant_copy'] != 0? '' : 'hidden')?>" data-disabled="applicant_copy">
          <div class="input-value">
            <div class="name-section">Institution:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_institution'])? $check['ap_institution'] : '')?> type="text" name="ap_institution" value="<?=hsc($_POST['ap_institution'])?>">
          </div>

          <div class="input-value">
            <div class="name-section">Attention To:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_attention_to'])? $check['ap_attention_to'] : '')?> type="text" name="ap_attention_to" value="<?=hsc($_POST['ap_attention_to'])?>">
          </div>

          <div class="input-value">
            <div class="name-section">Department:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_department'])? $check['ap_department'] : '')?> type="text" name="ap_department" value="<?=hsc($_POST['ap_department'])?>">
          </div>

          <div class="input-value">
            <div class="name-section">Address Line 1:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_address1'])? $check['ap_address1'] : '')?> type="text" name="ap_address1" value="<?=hsc($_POST['ap_address1'])?>">
          </div>

          <div class="input-value">
            <div class="name-section">Address Line 2:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_address2'])? $check['ap_address2'] : '')?> type="text" name="ap_address2" value="<?=hsc($_POST['ap_address2'])?>">
          </div>

          <div class="input-value">
            <div class="name-section">City:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_city'])? $check['ap_city'] : '')?> type="text" name="ap_city" value="<?=hsc($_POST['ap_city'])?>">
          </div>
        </div>


        <div class="line-input-free <?=($_POST['applicant_copy'] == 1? '' : 'hidden')?>" data-section="1">
          <div class="input-value">
            <div class="name-section">Country: <b>United States</b></div>
          </div>

          <div class="input-value">
            <div class="name-section">State: <span class="accent">*</span></div>
            <select name="ap_state" <?=(isset($check['ap_state'])? $check['ap_state'] : '')?>>
              <?php foreach($param[4]['ap_state'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(($_POST['ap_state'] == $k || !isset($error) && $k == '')? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="input-value">
            <div class="name-section">Zip Code:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_zip_code'])? $check['ap_zip_code'] : '')?> type="text" name="ap_zip_code" value="<?=hsc($_POST['ap_zip_code'])?>">
          </div>
        </div>

        <div class="line-input-free <?=($_POST['applicant_copy'] == 2? '' : 'hidden')?>" data-section="2">
          <div class="input-value">
            <div class="name-section">County:<span class="accent">*</span></div>
            <select name="ap_country" <?=(isset($check['ap_country'])? $check['ap_country'] : '')?>>
              <?php foreach($param[4]['ap_country'] as $k => $value){ ?>
                <option value="<?=$k?>" <?=(($_POST['ap_country'] == $k || !isset($error) && $k == '')? 'selected' : "")?>>
                  <?=$value?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="input-value">
            <div class="name-section">Region:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_region'])? $check['ap_region'] : '')?> type="text" name="ap_region" value="<?=hsc($_POST['ap_region'])?>">
          </div>

          <div class="input-value">
            <div class="name-section">Postal code:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_postal_code'])? $check['ap_postal_code'] : '')?> type="text" name="ap_postal_code" value="<?=hsc($_POST['ap_postal_code'])?>">
          </div>
        </div>

        <div class="line-input-two <?=($_POST['applicant_copy'] != 0? '' : 'hidden')?>" data-disabled="applicant_copy">
          <div class="input-value">
            <div class="name-section">Phone:<span class="accent">*</span></div>
            <input <?=(isset($check['ap_phone'])? $check['ap_phone'] : '')?> type="text" name="ap_phone" value="<?=hsc($_POST['ap_phone'])?>" placeholder="example: 000-000-0000">
          </div>
        </div>

        <div class="line-input-two <?=($_POST['applicant_copy'] != 0? '' : 'hidden')?>" data-disabled="applicant_copy">
          <div class="input-value <?=($_POST['applicant_copy'] == 1? '' : 'hidden')?>" data-section="1">
            <div class="name-section">Mailing Options:<span class="accent">*</span></div>
            <?php foreach($param[4]['ap_mailing_us'] as $k => $v){ ?>
              <label><input type="radio" name="ap_mailing_us" value="<?=$k?>" <?=(isset($check['ap_mailing_us'])? $check['ap_mailing_us'] : '')?> <?=(isset($_POST['ap_mailing_us']) && $_POST['ap_mailing_us'] == $k || $k == 0? 'checked' : "")?>><?=$v['text']?>($<?=$v['price']?>)
              </label>
            <?php } ?>
          </div>

          <div class="input-value <?=($_POST['applicant_copy'] == 2? '' : 'hidden')?>" data-section="2">
            <div class="name-section">Mailing Options:<span class="accent">*</span></div>
            <?php foreach($param[4]['ap_mailing_all'] as $k => $v){ ?>
              <label><input type="radio" name="ap_mailing_all" value="<?=$k?>" <?=(isset($check['ap_mailing_all'])? $check['ap_mailing_all'] : '')?> <?=(isset($_POST['ap_mailing_all']) && $_POST['ap_mailing_all'] == $k || $k == 0? 'checked' : "")?>><?=$v['text']?>($<?=$v['price']?>)
              </label><br>
            <?php } ?>
          </div>

          <div class="input-value">
            <div class="name-section">I acknowledge that IERF accepts no liability related to the loss or damage of documents during mailing.<span class="accent">*</span>
            </div>
            <input type="checkbox" name="ap_liability" value="1" <?=(isset($_POST['ap_liability']) && $_POST['ap_liability'] == 1? 'checked' : "")?> <?=(isset($check['ap_liability'])? $check['ap_liability'] : '')?>>
          </div>
        </div>

        <div class="header-line">My Additional Official Agency Copy</div>
        <div class="spec-block-list">
          <?php if($copyAgency->num_rows > 0){
            while($arCopy = hsc($copyAgency->fetch_assoc())){

              ?>
              <div class="spec-block2">
                <p>Text: <?=$arCopy['text_copy']?></p>
                <p><?=$param[4]['mailing_copy'][$arCopy['mailing_copy']]['text'].' $'.$param[4]['mailing_copy'][$arCopy['mailing_copy']]['price']?></p>
                <a href="/admin/cab/copy-agency/?edit=<?=$arCopy['id']?>">View</a>
              </div>
            <?php }
          } ?>
        </div>

        <div class="header-line">Services & Fees</div>
        <div class="line-input">
          <div class="input-value">
            <div class="name-section"><b>Please select a turnaround time:</b><span class="accent">*</span></div>
            <br>
            <?php foreach($param[5]['turnaround_time'] as $k => $v){ ?>
              <label><input type="radio" name="turnaround_time" value="<?=$k?>" <?=(isset($check['turnaround_time'])? $check['turnaround_time'] : '')?> <?=(isset($_POST['turnaround_time']) && $_POST['turnaround_time'] == $k || $k == 0? 'checked' : "")?>><?=$v['text']?>
              </label>
            <?php } ?>
          </div>
        </div>

        <div class="header-line">Special Instructions or Comments (if applicable)</div>
        <div class="input-value">
          <div class="name-section">If there was a significantly large gap in time between the date of completion of the program and the date of the award of the qualification, please explain why below (limit 1000 characters):</div>
          <textarea class="big-height" name="end_comment"><?=(isset($_POST['end_comment'])? hsc($_POST['end_comment']) : $arResult['end_comment'])?></textarea>
        </div>

      </div>
      <input type="hidden" name="idCard" value="<?=$_POST['idCard']?>">

      <input type="submit" value="<?=$messG['Зберегти']?>" name="ok">
    </form>
  </div>
<?php } else { ?>
  <div class="filter">
    <div class="filter-name"><?=$messG['Фільтр']?></div>
    <form action="" method="get">
      <div class="add-field-filter icon-plus"></div>
      <div class="filter-option-list">
        <?php foreach($application_info['setting_column'] as $k => $value){
          if($value['view_filter']){
            echo '<div class="'.(isset($_COOKIE['filter']) && in_array($value['index'], (array)json_decode($_COOKIE['filter']))? 'act-option' : '').'" data-index="'.(int)$value['index'].'">'.$value['name'].'</div>';
          }
        } ?>
      </div>
      <?=$application_info['html_filter']?>
      <input type="submit" name="filter" value="<?=$messG['Пошук']?>">
      <a href="/admin/cab/?filterReset=ok"><?=$messG['Відмінити']?></a>
    </form>
  </div>

  <div class="section-interface-k1">
    <div class="line-custom">
      <p class="header-name">Список карточок</p>
    </div>

    <form action="" method="post" onsubmit="return okFrom();">
      <div class="line-custom-next">
        <a href="/admin/cab/?add=ok" class="add-el icon-plus"><?=$messG['Створити елемент']?></a>
        <input type="submit" value="<?=$messG['Активувати']?>" name="activate" class="option-el">
        <input type="submit" value="<?=$messG['Деактивувати']?>" name="deactivate" class="option-el">
        <input type="submit" value="<?=$messG['Видалити']?>" name="delete" class="option-el">
        <div class="dynamicEdit" data-submit-lang="<?=$messG['Зберегти'].'|'.$messG['Відмінити']?>"></div>
      </div>

      <table class="illustration-table">
        <tr>
          <td><input type="checkbox" name="all_cheked"></td>
          <td></td>
          <?php foreach($application_info['column_list'] as $k => $v){
            if($application_info['setting_column'][$v]['view_table']){ ?>
              <td><?=$application_info['setting_column'][$v]['name']?></td>
            <?php }
          } ?>
        </tr>

        <?php if($application_info['result_DB']->num_rows > 0){
          while($arResult = hsc($application_info['result_DB']->fetch_assoc())){ ?>
            <tr data-id="<?=$arResult['id']?>">
              <td><input type="checkbox" name="ids[]" value="<?=$arResult['id']?>"></td>
              <td class="relative">
                <span class="icon-mob-menu" onclick="openMenuUpdate(this);"></span>
                <div class="menu-update">
                  <a href="/admin/cab/?edit=<?=$arResult['id']?>"><?=$messG['Редагувати']?></a>
                  <a href="/admin/cab/?delete=<?=$arResult['id']?>"><?=$messG['Видалити']?></a>
                </div>
              </td>
              <?php foreach($arResult as $k => $value){
                if($application_info['setting_column'][$k]['view_table']){ ?>
                  <td <?=(($application_info['setting_column'][$k]['edit_window'] == 1)? 'data-field="'.$k.'"' : '')?>><?=(($application_info['setting_column'][$k]['field'] == 'tinyint')? $messG[$k][$value] : $value)?></td>
                <?php }
              } ?>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td>-</td>
            <td>-</td>
            <?php foreach($application_info['setting_column'] as $k => $v){
              if($v['view_table']){ ?>
                <td>-</td>
              <?php }
            } ?>
          </tr>
        <?php } ?>
      </table>
    </form>

    <div class="bottom-table">
      <?=$application_info['count_el_page']?>
      <?=$application_info['pagination']?>
    </div>
  </div>
<?php } ?>