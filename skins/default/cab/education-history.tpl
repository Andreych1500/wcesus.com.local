<form class="clear-fix bg-net" data-clear="clear" action="" method="post">
  <div class="steps">
    <?php for($i = 1; $i <= 7; ++$i){ ?>
      <div <?=(($i == 2)? 'class="active"' : '')?>>Step <?=$i?></div>
    <?php } ?>
  </div>

  <div class="header-question">Educational History</div>

  <?php if(isset($info) && $info['type'] != 'good'){ ?>
    <div class="modalWindow">
      <div class="modal-content">
        <span class="icon-error"></span> <i>Important Message</i>
        <?=$info['text']?>
        <div class="close">Close</div>
      </div>
    </div>
  <?php } ?>

  <div class="style-text-block">
    <p>List all educational institutions you have attended or are attending, starting with secondary institutions. Include the name of each certificate/diploma as it appears on your document(s). After you enter each school/program of study, please press the Submit button.</p>
    <p>The saved information will appear in the first box below. You will be able to edit or remove each entry, if needed.</p>
  </div>

  <div class="section-question">My Educational History</div>

  <div class="educational-block">
    <?php if($getHistory->num_rows > 0){
      while($history = hsc($getHistory->fetch_assoc())){ ?>
        <div class="items-history">
          <div><?=$history['name_institution']?></div>
          <div><?=$history['diploma_name']?></div>
          <div>
            <a href="/cab/education-history/?edit=<?=$history['id']?>">Edit</a> /
            <a href="/cab/education-history/?remove=<?=$history['id']?>">Remove</a>
          </div>
        </div>
      <?php }
    } else { ?>
      <div class="items-history">No educational history entered</div>
    <?php } ?>
  </div>

  <div class="section-question">Educational History</div>

  <div class="line-input-free">
    <div class="input-value">
      <div class="name-section">County:<span class="accent">*</span></div>
      <select name="country_study" <?=(isset($check['country_study'])? $check['country_study'] : '')?>>
        <?php foreach($param['country_study'] as $k => $value){ ?>
          <option value="<?=$k?>" <?=(((isset($_POST['country_study']) && $_POST['country_study'] == $k) || !isset($error) && $k == '')? 'selected' : "")?>>
            <?=$value?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="input-value">
      <div class="name-section">City:<span class="accent">*</span></div>
      <input <?=(isset($check['city'])? $check['city'] : '')?> type="text" name="city" value="<?=(isset($error) || isset($_POST['city'])? hsc($_POST['city']) : "")?>">
    </div>

    <div class="input-value">
      <div class="name-section">Name of Institution:<span class="accent">*</span></div>
      <input <?=(isset($check['name_institution'])? $check['name_institution'] : '')?> type="text" name="name_institution" value="<?=(isset($error) || isset($_POST['name_institution'])? hsc($_POST['name_institution']) : "")?>">
    </div>
  </div>

  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">Dates Attended <b>From</b> (mm/yyyy): <span class="accent">*</span></div>
      <select name="date_mm_from" <?=(isset($check['date_mm_from'])? $check['date_mm_from'] : '')?>>
        <?php foreach($param['date_mm_from'] as $k => $v){ ?>
          <option value="<?=$v?>" <?=(((isset($_POST['date_mm_from']) && $_POST['date_mm_from'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select> / <select name="date_yyyy_from" <?=(isset($check['date_yyyy_from'])? $check['date_yyyy_from'] : '')?>>
        <?php foreach($param['date_yyyy_from'] as $k => $v){ ?>
          <option value="<?=$v?>" <?=(((isset($_POST['date_yyyy_from']) && $_POST['date_yyyy_from'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>
    <div class="input-value">
      <div class="name-section">Dates Attended <b>To</b> (mm/yyyy): <span class="accent">*</span></div>
      <select name="date_mm_to" <?=(isset($check['date_mm_to'])? $check['date_mm_to'] : '')?>>
        <?php foreach($param['date_mm_to'] as $k => $v){ ?>
          <option value="<?=$v?>" <?=(((isset($_POST['date_mm_to']) && $_POST['date_mm_to'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select> / <select name="date_yyyy_to" <?=(isset($check['date_yyyy_to'])? $check['date_yyyy_to'] : '')?>>
        <?php foreach($param['date_yyyy_to'] as $k => $v){ ?>
          <option value="<?=$v?>" <?=(((isset($_POST['date_yyyy_to']) && $_POST['date_yyyy_to'] == $v) || !isset($error) && $k == 0)? 'selected' : "")?>>
            <?=$v?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>

  <div class="line-input-two">
    <div class="header-inputs <?=(isset($check['fileScan'])? $check['fileScan'] : '')?>">File scan (only: JPG, PNG, GIF): <span class="accent">*</span></div>

    <?php foreach($_POST['fileScan'] as $key => $file){ ?>
      <div class="input-value upload_file" id="fileScan_<?=$key?>" data-priority-type="img">
        <?php $exist_file = fileExist($file); ?>
        <button type="button" onclick="getIdElement(this)">
          <span class="icon-link"></span><?=(!empty($exist_file)? $file : 'Select file')?>
        </button>
        <input name="fileScan[]" type="hidden" value="<?=(!empty($exist_file)? $file : '')?>">
        <input name="del[fileScan][]" type="hidden" value="<?=(isset($_POST['del']['fileScan'][$key])? hsc($_POST['del']['fileScan'][$key]) : $file)?>">
        <div class="photos <?=(!empty($exist_file)? '' : 'hidden')?>">
          <span class="removeFile" onclick="removeImage(this)">x</span>
          <img src="<?=$exist_file?>">
        </div>
      </div>
    <?php } ?>

    <div class="add_more">Add more</div>
  </div>

  <div class="line-input-two">
    <div class="input-value">
      <div class="name-section">Name of Diploma or Certificate, if Awarded:</div>
      <input type="text" name="diploma_name" value="<?=(isset($error) || isset($_POST['diploma_name'])? hsc($_POST['diploma_name']) : '')?>">
      <div class="under-text">(if possible, please provide the name of the certificate/diploma in the original language)</div>
    </div>
  </div>

  <div class="line-input">
    <div class="input-value">
      <div class="name-section">If there was a significantly large gap in time between the date of completion of the program and the date of the award of the qualification, please explain why below (limit 1000 characters):</div>
      <textarea <?=(isset($check['reason_text'])? $check['reason_text'] : '')?> name="reason_text"><?=(isset($error) || isset($_POST['reason_text'])? hsc($_POST['reason_text']) : "")?></textarea>
    </div>
  </div>

  <div class="ajaxToDb">
    <?php if(!isset($_REQUEST['edit'])){ ?>
      <span class="clear">Clear</span>
    <?php } ?>
    <input type="submit" name="add_history" value="Submit" class="subGo">
  </div>

  <input type="hidden" name="update" value="<?=$_POST['update']?>">

  <div class="save-or-continue">
    <a href="/cab/application-info/" title="application-info" class="back_link">< Back</a>
    <input type="submit" name="ok" value="Continue >">
  </div>
</form>

<form action="" id="to_file" enctype="multipart/form-data">
  <input id="control" type="file" name="file" onchange="addFile(this)" data-input="" data-name-submit="Select file">
</form>