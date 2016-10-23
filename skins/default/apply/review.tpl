<form class="clear-fix bg-net fixed-mobile" data-clear="clear" action="/apply/review/" method="post">
  <div class="steps">
    <?php for($i = 1; $i <= 7; ++$i){ ?>
      <div <?=(($i == 6)? 'class="active"' : '')?>>Step <?=$i?></div>
    <?php } ?>
  </div>

  <div class="header-question">Review</div>
  <div class="input-value">Please review your application and verify that all the information is accurate and complete. If you need to make any corrections to your application, please click on the tab(s) above or click on the edit button for any section below.</div>

  <div class="section-question">Applicant Information
    <a href="/apply/application-info/?review=back" title="Edit applicant Information">Edit</a>
  </div>
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
      <td><?=$arResult['country'].', '.$arResult['state'].$arResult['region'].', '.$arResult['addressOneLine'].', '.(!empty($arResult['addressTwoLine'])? $arResult['addressTwoLine'].', ' : '').$arResult['city'].', '.$arResult['zip_code'].$arResult['postal_code']?></td>
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

  <div class="section-question">Educational History
    <a href="/apply/education-history/?review=back" title="Edit education history">Edit</a>
  </div>
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

  <div class="section-question">
    Purpose of Evaluation <a href="/apply/purpose/?review=back" title="Edit purpose">Edit</a>
  </div>

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
  </table>

  <div class="section-question">Mailing Instructions
    <a href="/apply/mailing/?review=back" title="Edit mailing instructions">Edit</a>
  </div>
  <table class="table-view-data">
    <tr>
      <td>Mail my applicant copy to:</td>
      <td><?=$arResult['applicant_copy']?></td>
    </tr>
    <tr>
      <td>First Name:</td>
      <td><?=$arResult['ap_first_name']?></td>
    </tr>
    <tr>
      <td>Last Name:</td>
      <td><?=$arResult['ap_last_name']?></td>
    </tr>
    <tr>
      <td>Middle Name:</td>
      <td><?=$arResult['ap_middle_name']?></td>
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

  <div class="section-question">
    Sum Services & Fees <a href="/apply/services/?review=back" title="Edit services & fees">Edit</a>
  </div>
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

  <div class="section-question">Special Instructions or Comments (if applile)</div>
  <div class="line-input">
    <div class="input-value">
      <div class="name-section">If there was a significantly large gap in time between the date of completion of the program and the date of the award of the qualification, please explain why below (limit 1000 characters):</div>
      <textarea class="big-height" name="end_comment"><?=(isset($_POST['end_comment'])? hsc($_POST['end_comment']) : $arResult['end_comment'])?></textarea>
    </div>
  </div>

  <input type="hidden" name="update" value="<?=$_POST['update']?>">

  <div class="save-or-continue">
    <a href="/apply/services/" title="application-info" class="back_link">< Back</a>
    <input type="submit" name="ok" value="Continue >">
  </div>
</form>