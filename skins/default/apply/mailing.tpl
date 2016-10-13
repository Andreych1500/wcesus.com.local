<form class="clear-fix bg-net" data-clear="clear" action="" method="post">
  <div class="steps">
    <?php for($i = 1; $i <= 7; ++$i){ ?>
      <div <?=(($i == 4)? 'class="active"' : '')?>>Step <?=$i?></div>
    <?php } ?>
  </div>

  <div class="header-question">Mailing Instructions</div>

  <div class="section-question">Copies and Fees</div>
  <div class="style-text-block">
    <p>The report fee includes one applicant copy and one official agency copy, which may be sent to an institution, organization, or employer.</p>
    <p>You may also request additional official copies at this time for an additional cost of $20 per copy.</p>
  </div>

  <div class="section-question">Mailing Options and Fees</div>
  <div class="style-text-block">
    <p>Evaluations are sent via regular mail unless original documents are submitted.</p>
    <p>If submitting <b>original documents</b>, please select either <b>Domestic Secure Mailing</b> or
      <b>Domestic Next Day Delivery</b> (which will have a tracking number) for the return of your academic records. Otherwise your documents will not be returned to you, unless you instruct us in writing to return them via regular mail. WCES accepts no liability related to the loss or damage of documents during mailing.
    </p>
    <p>You may request Domestic Secure Mailing for $20 per address, Domestic Next Day Delivery for $65 per address, or International Secure Mailing for $125 per address. Please note that you must provide a street address when requesting Secure Mailing or Next Day Delivery (no P.O. Boxes), as well as a phone number.</p>
  </div>

  <div class="section-question">Applicant Copy (report sent to you - included in the report fee)</div>
  <div class="line-input">
    <div class="input-value">
      <div class="name-section">Please mail my applicant copy and my original documents (if submitted) to:
        <span class="accent">*</span>
      </div>
      <select name="applicant_copy" <?=(isset($check['applicant_copy'])? $check['applicant_copy'] : '')?>>
        <?php foreach($param['applicant_copy'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['applicant_copy']) && $_POST['applicant_copy'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="line-input-free <?=($_POST['applicant_copy'] != 0? '' : 'hidden')?>" data-hidden="applicant_copy">
    <div class="input-value">
      <div class="name-section">First Name:<span class="accent">*</span></div>
      <input <?=(isset($check['ap_first_name'])? $check['ap_first_name'] : '')?> type="text" name="ap_first_name" value="<?=hsc($_POST['ap_first_name'])?>">
    </div>

    <div class="input-value">
      <div class="name-section">Last Name:<span class="accent">*</span></div>
      <input <?=(isset($check['ap_last_name'])? $check['ap_last_name'] : '')?> type="text" name="ap_last_name" value="<?=hsc($_POST['ap_last_name'])?>">
    </div>

    <div class="input-value">
      <div class="name-section">Middle Name:</div>
      <input type="text" name="ap_middle_name" value="<?=hsc($_POST['ap_middle_name'])?>">
    </div>

    <div class="input-value">
      <div class="name-section">Address Line 1:<span class="accent">*</span></div>
      <input <?=(isset($check['ap_address1'])? $check['ap_address1'] : '')?> type="text" name="ap_address1" value="<?=hsc($_POST['ap_address1'])?>">
    </div>

    <div class="input-value">
      <div class="name-section">Address Line 2:</div>
      <input type="text" name="ap_address2" value="<?=hsc($_POST['ap_address2'])?>">
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
        <?php foreach($param['ap_state'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['ap_state']) && $_POST['ap_state'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
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
        <?php foreach($param['ap_country'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['ap_country']) && $_POST['ap_country'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
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

  <div class="line-input-two <?=($_POST['applicant_copy'] != 0? '' : 'hidden')?>" data-hidden="applicant_copy">
    <div class="input-value">
      <div class="name-section">Phone:<span class="accent">*</span></div>
      <input <?=(isset($check['ap_phone'])? $check['ap_phone'] : '')?> type="text" name="ap_phone" value="<?=hsc($_POST['ap_phone'])?>">
    </div>
  </div>

  <div class="line-input-two <?=($_POST['applicant_copy'] != 0? '' : 'hidden')?>" data-hidden="applicant_copy">
    <div class="input-value <?=($_POST['applicant_copy'] == 1? '' : 'hidden')?>" data-section="1">
      <div class="name-section">Mailing Options:<span class="accent">*</span></div>
      <?php foreach($param['ap_mailing_us'] as $k => $v){ ?>
        <label><input type="radio" name="ap_mailing_us" value="<?=$k?>" <?=(isset($check['ap_mailing_us'])? $check['ap_mailing_us'] : '')?> <?=(isset($_POST['ap_mailing_us']) && $_POST['ap_mailing_us'] == $k || $k == 1? 'checked' : "")?>><?=$v['text']?>($<?=$v['price']?>)
        </label><br>
      <?php } ?>
    </div>

    <div class="input-value <?=($_POST['applicant_copy'] == 2? '' : 'hidden')?>" data-section="2">
      <div class="name-section">Mailing Options:<span class="accent">*</span></div>
      <?php foreach($param['ap_mailing_all'] as $k => $v){ ?>
        <label><input type="radio" name="ap_mailing_all" value="<?=$k?>" <?=(isset($check['ap_mailing_all'])? $check['ap_mailing_all'] : '')?> <?=(isset($_POST['ap_mailing_all']) && $_POST['ap_mailing_all'] == $k || $k == 1? 'checked' : "")?>><?=$v['text']?>($<?=$v['price']?>)
        </label><br>
      <?php } ?>
    </div>

    <div class="input-value">
      <div class="name-section">I acknowledge that WCES accepts no liability related to the loss or damage of documents during mailing.<span class="accent">*</span>
      </div>
      <input type="checkbox" name="ap_liability" value="1" <?=($_POST['ap_liability'] == 1? 'checked' : "")?> <?=(isset($check['ap_liability'])? $check['ap_liability'] : '')?>>
    </div>
  </div>

  <div class="section-question">My Additional Official Agency Copy</div>
  <div class="educational-block">
    <?php if($oac->num_rows > 0){
      while($res = hsc($oac->fetch_assoc())){ ?>
        <div class="items-history">
          <div><?=(strlen($res['text_copy']) > 30? substr($res['text_copy'], 0, 30).'...' : $res['text_copy'])?></div>
          <?php $el = $param['mailing_copy'][$res['mailing_copy']]; ?>
          <div><?=$el['text'].' ($'.$el['price'].') '?></div>
          <div>
            <a href="/apply/mailing/?edit=<?=$res['id']?>">Edit</a> /
            <a href="/apply/mailing/?remove=<?=$res['id']?>">Remove</a>
          </div>
        </div>
      <?php }
    } else { ?>
      <div class="items-history">No additional Official Agency Copy</div>
    <?php } ?>
  </div>

  <div class="section-question">Additional Official Agency Copy (+$20)</div>
  <div class="style-text-block">
    <p>If you would like to request an additional copy at this time, please fill in the section below.(LIMIT 4)</p>
    <p>Enter the Institution Name; Contact Person; Full Address; and Phone Number.</p>
    <p>For electronic delivery, provide Email Address or Fax Number.</p>
  </div>

  <div class="input-value">
    <div class="name-section">Text copy:<span class="accent">*</span></div>
    <textarea class="big-height <?=(isset($check['text_copy'])? $check['text_copy'] : '')?>" name="text_copy"><?=(isset($_POST['text_copy'])? hsc($_POST['text_copy']) : "")?></textarea>
  </div>

  <div class="input-value">
    <div class="name-section">Mailing Options:<span class="accent">*</span></div>
    <?php foreach($param['mailing_copy'] as $k => $v){ ?>
      <label><input type="radio" name="mailing_copy" value="<?=$k?>" <?=(isset($check['mailing_copy'])? $check['mailing_copy'] : '')?> <?=(isset($_POST['mailing_copy']) && $_POST['mailing_copy'] == $k || $k == 1? 'checked' : "")?>><?=$v['text']?>($<?=$v['price']?>)
      </label><br>
    <?php } ?>
  </div>

  <div class="ajaxToDb">
    <input type="submit" name="add_copy" value="Submit" class="subGo">
  </div>

  <input type="hidden" name="update" value="<?=$_POST['update']?>">

  <div class="save-or-continue">
    <a href="/apply/purpose/" title="application-info" class="back_link">< Back</a>
    <input type="submit" name="ok" value="Continue >">
  </div>
</form>