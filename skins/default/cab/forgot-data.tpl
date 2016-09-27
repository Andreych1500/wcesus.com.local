<form class="clear-fix bg-net" action="" method="post">
  <div class="header-question">Restoring access to card</div>

  <div class="apply-user">Please enter the e-mail, which you used to access the site. If you would be incorrect email address, you will be sent a letter of authorization data in your profile.</div>

  <div class="input-value">
    <div class="name-section">Email:</div>
    <input <?=(isset($check['email'])? $check['email'] : '')?> type="text" name="email" value="<?=(isset($error) || isset($_POST['email'])? hsc($_POST['email']) : "")?>">
  </div>

  <div class="save-or-continue">
    <input type="submit" name="ok" value="Submit">
  </div>
</form>

<?php if(isset($info)){ ?>
  <div class="modalWindow">
    <div class="modal-content">
      <span class="like"></span> <i>Important Message</i>
      <?=$info['text']?>
      <div class="close">Close</div>
    </div>
  </div>
<?php } ?>