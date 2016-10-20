<form class="clear-fix bg-net" action="/apply/application-info/" method="post">
  <div class="steps">
    <?php for($i = 1; $i <= 7; ++$i){ ?>
      <div <?=(($i == 1)? 'class="active"' : '')?>>Step <?=$i?></div>
    <?php } ?>
  </div>

  <div class="header-question">Applicant Information</div>

  <div class="section-question">Personal Information</div>
  <div class="line-input-free">
    <div class="input-value">
      <div class="name-section">Last Name:<span class="accent">*</span></div>
      <input <?=(isset($check['last_name'])? $check['last_name'] : '')?> type="text" name="last_name" value="<?=(isset($_POST['last_name'])? hsc($_POST['last_name']) : '')?>">
    </div>

    <div class="input-value">
      <div class="name-section">First Name:<span class="accent">*</span></div>
      <input <?=(isset($check['first_name'])? $check['first_name'] : '')?> type="text" name="first_name" value="<?=(isset($_POST['first_name'])? hsc($_POST['first_name']) : '')?>">
    </div>

    <div class="input-value">
      <div class="name-section">Middle Name:</div>
      <input type="text" name="middle_name" value="<?=(isset($_POST['middle_name'])? hsc($_POST['middle_name']) : '')?>">
    </div>
  </div>

  <div class="line-input">
    <div class="input-value">
      <div class="name-section">Is the Name on Your Educational Records Different Than That Above?:
        <span class="accent">*</span>
      </div>
      <select name="is_records_name" <?=(isset($check['is_records_name'])? $check['is_records_name'] : '')?>>
        <?php foreach($param['is_records_name'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['is_records_name']) && $_POST['is_records_name'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="line-input-free <?=((isset($_POST['is_records_name']) && $_POST['is_records_name'] == 2)? '' : 'hidden')?>" data-hidden="is_records_name">
    <div class="input-value">
      <div class="name-section">Last Name (On Records):<span class="accent">*</span></div>
      <input <?=(isset($check['last_name_records'])? $check['last_name_records'] : '')?> type="text" name="last_name_records" value="<?=(isset($_POST['last_name_records'])? hsc($_POST['last_name_records']) : '')?>">
    </div>

    <div class="input-value">
      <div class="name-section">First Name (On Records):<span class="accent">*</span></div>
      <input <?=(isset($check['first_name_records'])? $check['first_name_records'] : '')?> type="text" name="first_name_records" value="<?=(isset($_POST['first_name_records'])? hsc($_POST['first_name_records']) : "")?>">
    </div>

    <div class="input-value">
      <div class="name-section">Middle Name (On Records): </div>
      <input type="text" name="middle_name_records" value="<?=(isset($_POST['middle_name_records'])? hsc($_POST['middle_name_records']) : "")?>">
    </div>
  </div>

  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">Date of Birth: (mm/dd/yyyy): <span class="accent">*</span></div>
      <select name="date_mm" <?=(isset($check['date_mm'])? $check['date_mm'] : '')?>>
        <?php foreach($param['date_mm'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['date_mm']) && $_POST['date_mm'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select> <select name="date_dd" <?=(isset($check['date_dd'])? $check['date_dd'] : '')?>>
        <?php foreach($param['date_dd'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['date_dd']) && $_POST['date_dd'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select> <select name="date_yyyy" <?=(isset($check['date_yyyy'])? $check['date_yyyy'] : '')?>>
        <?php foreach($param['date_yyyy'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['date_yyyy']) && $_POST['date_yyyy'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="input-value">
      <div class="name-section">Gender:<span class="accent">*</span></div>
      <select name="gender" <?=(isset($check['gender'])? $check['gender'] : '')?>>
        <?php foreach($param['gender'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['gender']) && $_POST['gender'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
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
        <?php foreach($param['country'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['country']) && $_POST['country'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="input-value">
      <div class="name-section">Address Line 1:<span class="accent">*</span></div>
      <input <?=(isset($check['addressOneLine'])? $check['addressOneLine'] : '')?> type="text" name="addressOneLine" value="<?=(isset($_POST['addressOneLine'])? hsc($_POST['addressOneLine']) : "")?>">
    </div>

    <div class="input-value">
      <div class="name-section">Address Line 2:</div>
      <input type="text" name="addressTwoLine" value="<?=(isset($_POST['addressTwoLine'])? hsc($_POST['addressTwoLine']) : "")?>">
    </div>
  </div>

  <div class="line-input-free">
    <div class="input-value">
      <div class="name-section">City:<span class="accent">*</span></div>
      <input <?=(isset($check['city'])? $check['city'] : '')?> type="text" name="city" value="<?=(isset($_POST['city'])? hsc($_POST['city']) : "")?>">
    </div>

    <div class="input-value <?=((isset($_POST['country']) && $_POST['country'] == 'USA')? '' : 'hidden')?>" data-section="USA">
      <div class="name-section">State: <span class="accent">*</span></div>
      <select name="state" <?=(isset($check['state'])? $check['state'] : '')?>>
        <?php foreach($param['state'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['state']) && $_POST['state'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="input-value <?=((isset($_POST['country']) && $_POST['country'] == 'USA')? '' : 'hidden')?>" data-section="USA">
      <div class="name-section">Zip Code:<span class="accent">*</span></div>
      <input <?=(isset($check['zip_code'])? $check['zip_code'] : '')?> type="text" name="zip_code" value="<?=(isset($_POST['country'])? hsc($_POST['zip_code']) : "")?>">
    </div>

    <div class="input-value <?=((!isset($_POST['country']) || $_POST['country'] != 'USA')? '' : 'hidden')?>" data-section="All">
      <div class="name-section">Region:<span class="accent">*</span></div>
      <input <?=(isset($check['region'])? $check['region'] : '')?> type="text" name="region" value="<?=(isset($_POST['region'])? hsc($_POST['region']) : "")?>">
    </div>

    <div class="input-value <?=((!isset($_POST['country']) || $_POST['country'] != 'USA')? '' : 'hidden')?>" data-section="All">
      <div class="name-section">Postal code:<span class="accent">*</span></div>
      <input <?=(isset($check['postal_code'])? $check['postal_code'] : '')?> type="text" name="postal_code" value="<?=(isset($_POST['postal_code'])? hsc($_POST['postal_code']) : "")?>">
    </div>
  </div>

  <div class="section-question">Contact Information</div>
  <div class="line-input-free">
    <div class="input-value">
      <div class="name-section">Day Phone:<span class="accent">*</span></div>
      <input <?=(isset($check['phone'])? $check['phone'] : '')?> type="text" name="phone" value="<?=(isset($_POST['phone'])? hsc($_POST['phone']) : "")?>">
    </div>

    <div class="input-value">
      <div class="name-section">Email Address:<span class="accent">*</span></div>
      <input <?=(isset($check['email'])? $check['email'] : '')?> type="text" name="email" value="<?=(isset($_POST['email'])? hsc($_POST['email']) : "")?>">
    </div>

    <div class="input-value">
      <div class="name-section">Cell Phone:</div>
      <input type="text" name="cell_phone" value="<?=(isset($_POST['cell_phone'])? hsc($_POST['cell_phone']) : "")?>">
    </div>
  </div>

  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">How did you hear about us?: <span class="accent">*</span></div>
      <select name="about_us" <?=(isset($check['about_us'])? $check['about_us'] : '')?>>
        <?php foreach($param['about_us'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['about_us']) && $_POST['about_us'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="input-value <?=((isset($_POST['about_us']) && $_POST['about_us'] == 7)? '' : 'hidden')?>" data-hidden="about_us">
      <div class="name-section">Your answer:<span class="accent">*</span></div>
      <textarea <?=(isset($check['about_us_answer'])? $check['about_us_answer'] : '')?> name="about_us_answer"><?=(isset($_POST['about_us_answer'])? hsc($_POST['about_us_answer']) : "")?></textarea>
    </div>
  </div>

  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">Have you ever previously used the services of WCES?: <span class="accent">*</span></div>
      <select name="services_WCES" <?=(isset($check['services_WCES'])? $check['services_WCES'] : '')?>>
        <?php foreach($param['services_WCES'] as $k => $v){ ?>
          <option value="<?=$k?>" <?=((isset($_POST['services_WCES']) && $_POST['services_WCES'] == $k || $k === 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div data-hidden="services_WCES" class="input-value <?=((isset($_POST['services_WCES']) && $_POST['services_WCES'] == 2)? '' : 'hidden')?>">
      <div class="name-section">Your old number profiles WCES:<span class="accent">*</span> </div>
      <input type="text" name="old_num_card" value="<?=(isset($_POST['old_num_card'])? hsc($_POST['old_num_card']) : "")?>" placeholder="Min 5 symbol" <?=(isset($check['old_num_card'])? $check['old_num_card'] : '')?>>
    </div>
  </div>

  <?php if(isset($_POST['update'])){ ?>
    <input type="hidden" name="update" value="<?=$_POST['update']?>">
  <?php } ?>

  <div class="save-or-continue">
    <input type="submit" name="ok" value="Continue >">
  </div>
</form>