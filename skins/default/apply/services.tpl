<form class="clear-fix bg-net" data-clear="clear" action="/apply/services/" method="post">
  <div class="steps">
    <?php for($i = 1; $i <= 7; ++$i){ ?>
      <div <?=(($i == 5)? 'class="active"' : '')?>>Step <?=$i?></div>
    <?php } ?>
  </div>

  <div class="header-question">Services & Fees</div>

  <div class="section-question">Rush Service</div>
  <div class="line-input">
    <div class="input-value">
      <p>If additional documentation and/or fees is/are required, the turnaround time will be effective from the date of receipt of all requested</p>
      <div class="name-section"><b>Please select a turnaround time:</b><span class="accent">*</span></div>
      <?php foreach($param['turnaround_time'] as $k => $v){ ?>
        <label><input type="radio" name="turnaround_time" value="<?=$k?>" <?=(isset($check['turnaround_time'])? $check['turnaround_time'] : '')?> <?=(isset($_POST['turnaround_time']) && $_POST['turnaround_time'] == $k || $k == 0? 'checked' : "")?>><?=$v['text'].' ($'.$v['price'].')'?>
        </label><br>
      <?php } ?>
      <div class="under-text small-text">* Days = Business Days</div>
    </div>
  </div>

  <?php if(isset($_POST['update'])){ ?>
    <input type="hidden" name="update" value="<?=$_POST['update']?>">
  <?php } ?>

  <div class="save-or-continue">
    <a href="/apply/mailing/" title="application-info" class="back_link">< Back</a>
    <input type="submit" name="ok" value="Continue >">
  </div>
</form>