<?php if($accessCab){ ?>
  <div class="clear-fix apply-user">
    <div class="header-question">Персональний кабінет</div>
    <div class="input-value"> Hello, ця сторінка є персональним кабінетом, для вашого профілю на цьому сайті. Тут ви можите змінити пароль, переглянути ваші заповнені дані анкети, та запросити додаткову копію з оплатою.</div>
    <div class="free-cab-block">
      <div data-section="1" <?=(isset($_COOKIE['open_tabs']) && $_COOKIE['open_tabs'] == 1? 'class="active"' : '')?>>Новий пароль</div>
      <div data-section="2" <?=(isset($_COOKIE['open_tabs']) && $_COOKIE['open_tabs'] == 2? 'class="active"' : '')?>>Показати анкету</div>
      <div data-section="3" <?=(isset($_COOKIE['open_tabs']) && $_COOKIE['open_tabs'] == 3? 'class="active"' : '')?>>Додаткова копія</div>
    </div>

    <div data-view-section="1" <?=(isset($_COOKIE['open_tabs']) && $_COOKIE['open_tabs'] == 1? 'style="display:block"' : '')?>>
      <form action="" method="post" class="line-input-free">
        <div class="input-value">
          <div class="name-section">Минулий пароль:<span class="accent">*</span></div>
          <input <?=(isset($check['your_password'])? $check['your_password'] : '')?> type="password" name="your_password" value="<?=(isset($_POST['your_password'])? hsc($_POST['your_password']) : "")?>">
        </div>

        <div class="input-value">
          <div class="name-section">Новий пароль:<span class="accent">*</span></div>
          <input <?=(isset($check['new_password'])? $check['new_password'] : '')?> type="password" name="new_password" value="<?=(isset($_POST['new_password'])? hsc($_POST['new_password']) : "")?>" placeholder="Min 6 symbol">
        </div>

        <div class="input-value">
          <div class="name-section">Повторыть знов:<span class="accent">*</span></div>
          <input <?=(isset($check['check_password'])? $check['check_password'] : '')?> type="password" name="check_password" value="<?=(isset($_POST['check_password'])? hsc($_POST['check_password']) : "")?>">
        </div>

        <div class="save-or-continue">
          <input type="submit" name="replace_password" value="Змінити пароль">
        </div>
      </form>
    </div>


    <div data-view-section="2" <?=(isset($_COOKIE['open_tabs']) && $_COOKIE['open_tabs'] == 2? 'style="display:block"' : '')?>>
      <div class="section-question">Applicant Information</div>
      <table class="table-view-data">
        <tr>
          <td>Name:</td>
          <td><?=$arResult['first_name'].' '.$arResult['last_name'].' '.$arResult['middle_name']?></td>
        </tr>
        <tr>
          <td>Date of Birth:</td>
          <td><?=$arResult['date_mm'].'/'.$arResult['date_dd'].'/'.$arResult['date_yyyy']?></td>
        </tr>
        <tr>
          <td>Address:</td>
          <td><?=$arResult['country'].', '.$arResult['state'].$arResult['region'].', '.$arResult['addressOneLine'].', '.$arResult['addressTwoLine'].', '.$arResult['city'].', '.$arResult['zip_code'].$arResult['postal_code']?></td>
        </tr>
        <tr>
          <td>Day Phone:</td>
          <td><?=$arResult['phone']?></td>
        </tr>
        <tr>
          <td>Email Address:</td>
          <td><?=$arResult['email']?></td>
        </tr>
      </table>

      <div class="section-question">Educational History</div>
      <?php if($arHistory->num_rows > 0){ ?>
        <table class="table-view-data style-table">
          <tr class="first-line">
            <td>Name of Institution</td>
            <td>Location</td>
            <td>Diploma/Certificate</td>
            <td>Dates Attended</td>
          </tr>
          <?php while($history = hsc($arHistory->fetch_assoc())){ ?>
            <tr>
              <td><?=$history['name_institution']?></td>
              <td><?=$history['city'].' ('.$param['country_study'][$history['country_study']].')'?></td>
              <td><?=$history['diploma_name']?></td>
              <td><?=$history['date_mm_from'].'/'.$history['date_yyyy_from'].' - '.$history['date_mm_to'].'/'.$history['date_yyyy_to']?></td>
            </tr>
            <tr>
              <td colspan="4">Comments for Name of Institution: <?=$history['reason_text']?><br><br></td>
            </tr>
          <?php } ?>
        </table>
      <?php } ?>

      <div class="section-question">Purpose of Evaluation</div>

      <table class="table-view-data">
        <tr>
          <td><b>Main Purpose:</td>
          <td>
            <?php if($arResult['main_purpose'] == 'Education'){
              echo $arResult['main_purpose'].' for: '.(is_array($arResult['admission_to'])? implode(', ', $arResult['admission_to']) : '');
            } elseif($arResult['main_purpose'] == 'Other') {
              echo $arResult['main_purpose'].': '.$arResult['please_spec'];
            } elseif($arResult['main_purpose'] != 'Choose one...') {
              echo $arResult['main_purpose'];
            } ?>
          </td>
        </tr>
        <tr>
          <td>Report Type:</td>
          <td><?=(is_array($arResult['report_type'])? $arResult['report_type']['name'] : '')?></td>
        </tr>
        <tr>
          <td>Additional Purpose(s):</td>
          <td><?=(is_array($arResult['admission_ap_pur'])? implode(', ', $arResult['admission_ap_pur']) : '')?></td>
        </tr>
      </table>

      <div class="section-question">Mailing Instructions</div>

      <table class="table-view-data">
        <tr>
          <td>Mail my applicant copy to:</td>
          <td><?=$arResult['applicant_copy']?></td>
        </tr>
        <tr>
          <td>Institution:</td>
          <td><?=$arResult['ap_institution']?></td>
        </tr>
        <tr>
          <td>Attention To:</td>
          <td><?=$arResult['ap_attention_to']?></td>
        </tr>
        <tr>
          <td>Department:</td>
          <td><?=$arResult['ap_department']?></td>
        </tr>
        <tr>
          <td>Address:</td>
          <td><?=$ap_address?></td>
        </tr>
        <tr>
          <td>Phone:</td>
          <td><?=$arResult['ap_phone']?></td>
        </tr>
        <tr>
          <td>Mailing Options:</td>
          <td><?=(is_array($arResult['ap_mailing'])? $arResult['ap_mailing']['text'] : '')?></td>
        </tr>
      </table>

      <div class="section-question">Mail my applicant copy:</div>
      <?php if($arAgencyCopy->num_rows > 0){ ?>
        <table class="table-view-data style-table">
          <tr class="first-line">
            <td>Mailing Options</td>
            <td>Text</td>
          </tr>
          <?php while($AgencyCopy = hsc($arAgencyCopy->fetch_assoc())){ ?>
            <tr>
              <td><?=$param['mailing_copy'][$AgencyCopy['mailing_copy']]['text']?></td>
              <td><?=$AgencyCopy['text_copy']?></td>
            </tr>
          <?php } ?>
        </table>
      <?php } ?>

      <div class="section-question">Sum Services & Fees</div>
      <table class="table-view-data style-table">
        <tr class="first-line">
          <td>Description</td>
          <td>Fee</td>
        </tr>
        <?php if(is_array($arResult['report_type'])){ ?>
          <tr>
            <td><?=$arResult['report_type']['name']?></td>
            <td>$<?=$arResult['report_type']['price']?></td>
          </tr>
        <?php } ?>
        <?php if($arAgencyCopy->num_rows > 0){ ?>
          <tr>
            <td>Copy agency</td>
            <td>$<?=$price?></td>
          </tr>
        <?php } ?>
        <?php if(is_array($arResult['ap_mailing'])){ ?>
          <tr>
            <td><?=$arResult['ap_mailing']['text']?></td>
            <td>$<?=$arResult['ap_mailing']['price']?></td>
          </tr>
        <?php } ?>
        <?php if(is_array($arResult['turnaround_time'])){ ?>
          <tr>
            <td>Turnaround time: <?=$arResult['turnaround_time']['text']?></td>
            <td>$<?=$arResult['turnaround_time']['price']?></td>
          </tr>
        <?php } ?>
      </table>
    </div>

    <div data-view-section="3" <?=(isset($_COOKIE['open_tabs']) && $_COOKIE['open_tabs'] == 3? 'style="display:block"' : '')?>>
      <form action="" method="post">
        <div class="section-question">My Additional Official Agency Copy (Limit 10)</div>
        <div class="educational-block">
          <?php if($new_copy->num_rows > 0){
            while($res = hsc($new_copy->fetch_assoc())){ ?>
              <div class="items-history">
                <div><?=(strlen($res['text_copy']) > 30? substr($res['text_copy'], 0, 30).'...' : $res['text_copy'])?></div>
                <?php $el = $param['mailing_copy'][$res['mailing_copy']]; ?>
                <div><?=$el['text'].' ($'.$el['price'].') '?></div>
                <div>
                  <?php if($res['payment_status'] == 0 && !isset($_GET['payment'])){ ?>
                    <a href="/cab/?payment=<?=$res['id']?>">Оплатити</a> /
                    <a href="/cab/?edit=<?=$res['id']?>">Edit</a> / <a href="/cab/?remove=<?=$res['id']?>">Remove</a>
                  <?php } elseif(isset($_GET['payment']) && $res['id'] != $_GET['payment']) { ?>
                    &#8212;
                  <?php } elseif(isset($_GET['payment']) && $res['id'] == $_GET['payment']) { ?>
                    Please wait 5 seconds...
                  <?php } elseif($res['payment_status'] == 2) { ?>
                    Іде провірка оплати!
                  <?php } else { ?>
                    <i><span class="icon-like"></span> Оплачено</i>
                  <?php } ?>
                </div>
              </div>
            <?php }
          } else { ?>
            <div class="items-history">No additional Official Agency Copy</div>
          <?php } ?>
        </div>

        <div class="section-question">Additional Official Agency Copy (+$20)</div>
        <div class="style-text-block">
          <p>If you would like to request an additional copy at this time, please fill in the section below.</p>
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
      </form>
    </div>
  </div>
<?php } else { ?>
  <div class="registration-block">
    <form action="" method="post">
      <img src="/skins/default/img/logo.png" alt="alt" title="title">
      <div class="form-group">
        <input type="email" name="email" placeholder="Email" <?=(isset($check['email'])? $check['email'] : "")?> value="<?=(isset($_POST['email'])? hsc($_POST['email']) : "")?>">
        <span class="icon-user"></span>
      </div>
      <div class="form-group">
        <input type="password" name="password" placeholder="Pasword" class="login-input <?=(isset($check['password'])? $check['password'] : '')?>" value="<?=(isset($_POST['password'])? hsc($_POST['password']) : '')?>">
        <span class="icon-lock"></span>
      </div>
      <div class="forgot-pass">
        <a href="/cab/forgot-password/" title="Forgot password?">Forgot password?</a>
        <label class="save-me"> Remember me: <input type="checkbox" name="save" value="save"></label>
      </div>
      <input type="submit" name="log_in" value="LOG IN" class="submit-style">
      <a href="/apply/" title="Apply Now" class="submit-style">Apply Now</a>
    </form>
  </div>
<?php } ?>