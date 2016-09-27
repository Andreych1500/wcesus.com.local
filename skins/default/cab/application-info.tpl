<form class="clear-fix bg-net" action="" method="post">
  <div class="steps">
    <?php for($i = 1; $i <= 7; ++$i){ ?>
      <div <?=(($i == 1)? 'class="active"' : '')?>>Step <?=$i?></div>
    <?php } ?>
  </div>

  <div class="header-question">Applicant Information</div>

  <?php if(isset($info) && $info['type'] != 'good'){ ?>
    <div class="modalWindow">
      <div class="modal-content">
        <span class="icon-error"></span> <i>Important Message</i>
        <?=$info['text']?>
        <div class="close">Close</div>
      </div>
    </div>
  <?php } ?>

  <div class="section-question">Personal Information</div>

  <div class="line-input-free">
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
        <?php foreach($param['is_records_name'] as $k => $value){ ?>
          <option value="<?=$k?>" <?=(((isset($_POST['is_records_name']) && $_POST['is_records_name'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$value?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="line-input-free <?=((isset($_POST['is_records_name']) && $_POST['is_records_name'] == 1)? '' : 'hidden')?>" data-disabled="is_records_name">
    <div class="input-value">
      <div class="name-section">Last Name (On Records):<span class="accent">*</span></div>
      <input <?=(isset($check['last_name_records'])? $check['last_name_records'] : '')?> type="text" name="last_name_records" value="<?=(isset($error) || isset($_POST['last_name_records'])? hsc($_POST['last_name_records']) : "")?>">
    </div>

    <div class="input-value">
      <div class="name-section">First Name (On Records):<span class="accent">*</span></div>
      <input <?=(isset($check['first_name_records'])? $check['first_name_records'] : '')?> type="text" name="first_name_records" value="<?=(isset($error) || isset($_POST['first_name_records'])? hsc($_POST['first_name_records']) : "")?>">
    </div>

    <div class="input-value">
      <div class="name-section">Middle Name (On Records):<span class="accent">*</span></div>
      <input type="text" name="middle_name_records" value="<?=(isset($error) || isset($_POST['first_name_records'])? hsc($_POST['middle_name_records']) : "")?>">
    </div>
  </div>

  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">Date of Birth: (mm/dd/yyyy): <span class="accent">*</span></div>
      <select name="date_mm" <?=(isset($check['date_mm'])? $check['date_mm'] : '')?>>
        <?php foreach($param['date_mm'] as $k => $v){ ?>
          <option value="<?=$v?>" <?=(((isset($_POST['date_mm']) && $_POST['date_mm'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select> <select name="date_dd" <?=(isset($check['date_dd'])? $check['date_dd'] : '')?>>
        <?php foreach($param['date_dd'] as $k => $v){ ?>
          <option value="<?=$v?>" <?=(((isset($_POST['date_dd']) && $_POST['date_dd'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select> <select name="date_yyyy" <?=(isset($check['date_yyyy'])? $check['date_yyyy'] : '')?>>
        <?php foreach($param['date_yyyy'] as $k => $v){ ?>
          <option value="<?=$v?>" <?=(((isset($_POST['date_yyyy']) && $_POST['date_yyyy'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="input-value">
      <div class="name-section">Gender:<span class="accent">*</span></div>
      <select name="gender" <?=(isset($check['gender'])? $check['gender'] : '')?>>
        <?php foreach($param['gender'] as $k => $value){ ?>
          <option value="<?=$k?>" <?=(((isset($_POST['gender']) && $_POST['gender'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$value?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="section-question">Address Information</div>

  <div class="line-input-free">
    <div class="input-value">
      <div class="name-section">County:<span class="accent">*</span></div>
      <select name="country" <?=(isset($check['country'])? $check['country'] : '')?>>
        <?php foreach($param['country'] as $k => $value){ ?>
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

  <div class="line-input-free">
    <div class="input-value">
      <div class="name-section">City:<span class="accent">*</span></div>
      <input <?=(isset($check['city'])? $check['city'] : '')?> type="text" name="city" value="<?=(isset($error) || isset($_POST['city'])? hsc($_POST['city']) : "")?>">
    </div>

    <div class="input-value <?=((isset($_POST['country']) && $_POST['country'] == 'USA')? '' : 'hidden')?>" data-disabled="country-USA">
      <div class="name-section">State: <span class="accent">*</span>
      </div>
      <select name="state" <?=(isset($check['state'])? $check['state'] : '')?>>
        <?php foreach($param['state'] as $k => $value){ ?>
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

  <div class="section-question">Contact Information</div>

  <div class="line-input-free">
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

  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">How did you hear about us?: <span class="accent">*</span>
      </div>
      <select name="about_us" <?=(isset($check['about_us'])? $check['about_us'] : '')?>>
        <?php foreach($param['about_us'] as $k => $value){ ?>
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

  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">Have you ever previously used the services of IERF?: <span class="accent">*</span></div>
      <select name="services_IERF" <?=(isset($check['services_IERF'])? $check['services_IERF'] : '')?>>
        <?php foreach($param['services_IERF'] as $k => $value){ ?>
          <option value="<?=$k?>" <?=(((isset($_POST['services_IERF']) && $_POST['services_IERF'] == $k) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$value?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>

  <?php if(isset($_POST['update'])){ ?>
    <input type="hidden" name="update" value="<?=$_POST['update']?>">
  <?php } ?>

  <div class="save-or-continue">
    <input type="submit" name="ok" value="Continue >">
  </div>
</form>